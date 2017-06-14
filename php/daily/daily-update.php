<?php
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

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
$atdQuery = new yangMysql(); $dailyQuery = new yangMysql(); $dailyCcQuery = new yangMysql();
$dailyQuery->selectDb(DB_DATABASE); //
$atdQuery->selectTable("attendance"); $dailyQuery->selectTable("daily"); $dailyCcQuery->selectTable("dailyCc");

/**
 * insert new attendance
 */
$id=$attendance['id'];
$att=$attendance['attendance']
$condition = "id = $id";
$result = $atdQuery->query("update attendance t set t.attendance = '$att' where t.id = '$id';");
$attendances = $atdQuery->simpleSelect(null, $condition, null, null);
if(!count($attendances)){
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
$dailys = $dailyQuery->simpleSelect(null, "attendance = '$id'", null, null);
$dailyCc = $dailyCcQuery->simpleSelect(null, "attendance = '$id'", null, null);
$response = [
  "attendance"=> count($attendances)?$attendances[0]:'',
  "dailys"=> count($dailys)?$dailys:'',
  "dailyCc"=> count($dailyCc)?$dailyCc:'',
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $response );
