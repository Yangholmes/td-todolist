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
$offset = $_POST['offset'];

//

/**
 * instance a new yangMysql class
 */
$atdQuery = new yangMysql();$dailyQuery = new yangMysql();
$atdQuery->selectTable("attendance"); 
$dailyQuery->selectTable("daily");
$condition = "user = '$user'";
$attendances = $atdQuery->simpleSelect(null, $condition, ['`createDate`', 'DESC'], [$offset,5]);
$results = array();
$dailys = [];
if($attendances === false){
	$error = '1';
	$errorMsg = '查询失败';
}else{
	$error = '0';
	if(count($attendances)){
		for($i=0; $i<count($attendances); $i++){
			$attendanceId = $attendances[$i]['id'];
			$condition2 = "attendance = '$attendanceId'";
			$dailys = $dailyQuery->simpleSelect(null, $condition2, null, null);
			array_push($results,["attendance"=>$attendances[$i], "dailys"=>$dailys]);
		}
		$errorMsg = '';
	}
	else{
		  $errorMsg = '查询纪录为空';
		}
}

$response = [
  "results"=> $results,
  "attendance"=>$attendances,
  "error"    => $error,
  "errorMsg" => $errorMsg
];

echo json_encode($response);
