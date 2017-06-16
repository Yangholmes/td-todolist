<?php
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');
require_once( __DIR__.'/../../php/api/Msg.php');

/**
 * recieve POST data
 */
$attendance = $_POST['attendance'];
$dailys      = $_POST['dailys'];
$dailyCc    = $_POST['dailyCc'];

// date filter

/**
 * instance a new yangMysql class
 */
$atdQuery = new yangMysql(); $dailyQuery = new yangMysql(); $dailyCcQuery = new yangMysql(); $userQuery = new yangMysql();
$dailyQuery->selectDb(DB_DATABASE); //
$atdQuery->selectTable("attendance"); $dailyQuery->selectTable("daily"); $dailyCcQuery->selectTable("dailyCc"); $userQuery->selectTable("user");

/**
 * insert new attendance
 */
$id=$attendance['id'];
$att=$attendance['attendance'];
$result = $atdQuery->query("update attendance set `attendance` = '$att' where id = '$id'");
$condition = "`id` = '$id'";
$attendances = $atdQuery->simpleSelect(null, $condition, null, null);
if(!count($attendances) && !$result){
  $error = '1';
  $errorMsg = '新增失败';
}
else{
  for($i=0; $i<count($dailys); $i++){
    $dailys[$i]['attendance'] = $attendance['id'];
    $dailyQuery->insert($dailys[$i]);
  }

  for($i=0; $i<count($dailyCc); $i++){
    $dailyCc[$i]['attendance'] = $attendance['id'];
    $dailyCcQuery->insert($dailyCc[$i]);
  }
  $error = '0';
  $errorMsg = '';
}
$dailys = $dailyQuery->simpleSelect(null, "`attendance` = '$id'", null, null);
$dailyCc = $dailyCcQuery->simpleSelect(null, "`attendance` = '$id'", null, null);
$response = [
  "attendance"=> count($attendances)?$attendances[0]:'',
  "dailys"=> count($dailys)?$dailys:'',
  "dailyCc"=> count($dailyCc)?$dailyCc:'',
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $response );

/**
 * [发钉钉企业消息]
 */
if($error == '0'){
  $user = $userQuery->simpleSelect(null, "`emplId` = '".$attendances[0]['user']."'", null, null)[0];

  /**
   * send Msg
   */
  $msg = new Msg(null);
  $respond = $msg->sendMsg([
  	"title" => $user['name']."的工作看板",
  	"touser"  => array_map(function($user){return $user['user'];}, $dailyCc),
  	"message_url" => SERVER_HOST."/msg-redirect.html?user=".$user['emplId']."&date=".$attendances[0]['createDate']."&signature=".randomIdFactory(10),
  	"image"=> "", // 图片
  	"rich" => ["num" => '', "unit" => $attendances[0]['createDate']],
  	"content" => "摘要："."\n".$dailys[0]['content']."\n……\n",
    "bgcolor" => "ff40B782"
  ]);
}
