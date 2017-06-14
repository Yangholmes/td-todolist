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
$atdQuery = new yangMysql(); $dailyQuery = new yangMysql(); $dailyCcQuery = new yangMysql();
$dailyQuery->selectDb(DB_DATABASE); //
$atdQuery->selectTable("attendance"); $dailyQuery->selectTable("daily"); $dailyCcQuery->selectTable("dailyCc");

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
  $id=$attendance['id'];
  $dailys = $dailyQuery->simpleSelect(null, "attendance = '$id'", null, null);
  $dailyCc = $dailyCcQuery->simpleSelect(null, "attendance = '$id'", null, null);
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
 * [if description]
 * @var [type]
 */
if($error == '0'){
  /**
   * send Msg
   */
  $msg = new Msg(null);
  $respond = $msg->sendMsg([
  	"title" => "",
  	"touser"  => ["03424264076698"],
  	"message_url" => "http://www.gdrtc.org/car/page/approval.html?resid=9dJemYZp1I9YGtHgdSK4{1490316119}",
  	"image"=> "", // 图片
  	"rich" => "哈哈哈",
  	"content" => "这是您的新申请这是您的新申请ff4da9eb哈哈哈哈哈",
    "bgcolor" => "ffff0000"
  ]);
}
