<?php

/**
 * 更新一条task记录
 * http方法： POST
 * 2017/06/12 Yangholmes
 */

/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

/**
 * recieve POST data
 */
$task = $_POST['task'];

// date filter

/**
 * instance a new yangMysql class
 */
$taskQuery  = new yangMysql(); //
$taskQuery->selectDb(DB_DATABASE); //
$taskQuery->selectTable("task");

/**
 * update the item
 */
$condition = "id = '".$task['id']."'";
$result = $taskQuery->update($task, $condition, null, null);

if(!$result){
  $error = '2';
  $errorMsg = '修改任务失败';
}
else{
  $task = $taskQuery->simpleSelect(null, $condition, null, null)[0];
  $error = '0';
  $errorMsg = '';
}

$response = [
  "task"     => $task,
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $response );
