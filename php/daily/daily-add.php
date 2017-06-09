<?php

/**
 * require libs
 */
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
}
