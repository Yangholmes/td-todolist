<?php
 /**
  * require libs
  */
 require_once( __DIR__.'/../../php/config/server-config.php');
 require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

 /**
  * recieve GET data
  */
$recieve = $_POST;
$user = $_POST['user'];
$createDate = $_POST['createDate'];
@$currentUser = $recieve['currentUser']?$_POST['currentUser']:false;

/**
 * instance a new yangMysql class
 */
$atdQuery = new yangMysql();$dailyQuery = new yangMysql();$dailyCcQuery = new yangMysql();
$atdQuery->selectTable("attendance");
$dailyQuery->selectTable("daily");
$dailyCcQuery->selectTable("dailyCc");
$condition = "user = '$user' AND createDate = '$createDate'";
$attendances = $atdQuery->simpleSelect(null, $condition, null, null);
$dailys = [];
if($attendances === false){
  $error = '1';
  $errorMsg = '查询失败';
}else{
  $error = '0';
  if(count($attendances)){
  	$attendanceId = $attendances[0]['id'];
  	$condition2 = "attendance = '$attendanceId'";
  	$dailys = $dailyQuery->simpleSelect(null, $condition2, null, null);
    // $dailyCc = $dailyCcQuery->simpleSelect(null, $condition2, null, null);
    if($currentUser){
      $updateCc = $dailyCcQuery ->query("update dailyCc set `read`=1 where attendance='$attendanceId' AND user='$currentUser'");
    }
    $dailyCc = $dailyCcQuery->query("select user.name,dailyCc.* from dailyCc LEFT JOIN user on user.emplId=dailyCc.user where attendance = '$attendanceId'");
    $errorMsg = '';
  }
  else{
		  $errorMsg = '查询纪录为空';
		}
}


if(!(count($attendances) && count($dailys))){

}else{
	$error = '0';
  $errorMsg = '';
}
$response = [
  "attendance"=> count($attendances)?$attendances[0]:'no attendance',
  "dailys"=> count($dailys)?$dailys:'no dailys',
  "dailyCc"=>count($dailyCc)?$dailyCc:'no dailyCc',
  "error"    => $error,
  "errorMsg" => $errorMsg
];

echo json_encode($response);
