<?php
 /**
  * require libs
  */
 require_once( __DIR__.'/../../php/config/server-config.php');
 require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

 /**
  * recieve GET data
  */
$user = $_POST['user'];
$createDate = $_POST['createDate'];

//

/**
 * instance a new yangMysql class
 */
$atdQuery = new yangMysql();$dailyQuery = new yangMysql();
$atdQuery->selectTable("attendance");
$dailyQuery->selectTable("daily");
$condition = "user = '$user' AND createDate = '$createDate'";
$attendances = $atdQuery->simpleSelect(null, $condition, null, null);
$dailys = [];
if($attendances === false){
  $error = '1';
  $errorMsg = '查询失败或纪录为空';
}else{
  $error = '0';
  if(count($attendances)){
  	$attendanceId = $attendances[0]['id'];
  	$condition2 = "attendance = '$attendanceId'";
  	$dailys = $dailyQuery->simpleSelect(null, $condition2, null, null);
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
  "error"    => $error,
  "errorMsg" => $errorMsg
];

echo json_encode($response);
