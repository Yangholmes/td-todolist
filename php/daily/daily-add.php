<?php
/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');
require_once( __DIR__.'/../../php/api/Msg.php');

/**
 * recieve POST data
 */
$attendance  = $_POST['attendance'];
$dailys      = $_POST['dailys'];
$dailyCc     = $_POST['dailyCc'];

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
$result = $attendance ? $atdQuery->insert($attendance) : false; // attendance can not be null

if(!$result){
  $error = '1';
  $errorMsg = '新增失败';
}
else{
  $result =$atdQuery->query('select @@IDENTITY');
  $attendance['id'] = $result[0]['@@IDENTITY'];

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
$response = [
  "attendance"=> $attendance,
  "dailys"=> $dailys,
  "dailyCc"=> $dailyCc,
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $response );

/**
 * [发钉钉企业消息]
 */
if($error == '0'){
  $user = $userQuery->simpleSelect(null, "`emplId` = '".$attendance['user']."'", null, null)[0]['name'];
  /**
   * send Msg
   */
  $msg = new Msg(null);
  $respond = $msg->sendMsg([
  	"title" => $user."的工作看板",
  	"touser"  => ["03424264076698"],
  	"message_url" => SERVER_HOST."/msg-redirect.html?user=03424264076698&date=2017-06-14"."&signature=".randomIdFactory(10),
  	"image"=> "", // 图片
  	"rich" => ["num" => '', "unit" => ""],
  	"content" => "摘要："."\n".$dailys[0]['content']."\n……\n",
    "bgcolor" => "ff40B782"
  ]);
}
