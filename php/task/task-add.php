<?php

/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

/**
 * recieve POST data
 */
$task = $_POST;

// date filter

/**
 * instance a new yangMysql class
 */
$taskQuery  = new yangMysql(); //
$resQuery->selectDb(DB_DATABASE); //
$resQuery->selectTable("task");

/**
 * insert new task
 */
$result = $taskQuery->insert($task);

if(!$result){
  $error = '1';
  $errorMsg = '新增任务失败'
}
else{
  $result =$taskQuery->query('select @@IDENTITY');
  $task['id'] = $result[0]['@@IDENTITY']
}

$result = [
  "task"     => $task,
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $result );
