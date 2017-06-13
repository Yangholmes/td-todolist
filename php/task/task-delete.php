<?php

/**
 * 删除一条task记录
 * http方法： POST
 * 2017/06/09 Yangholmes
 */

/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

/**
 * recieve POST data
 */
$id = $_POST['id'];

// date filter

/**
 * instance a new yangMysql class
 */
$taskQuery  = new yangMysql(); //
$taskQuery->selectDb(DB_DATABASE); //
$taskQuery->selectTable("task");

/**
 * delete a record
 */
$condition = "id = '$id'";
$result = $taskQuery->delete($condition);

$response = [
  "id"        => $id,
  "error"     => 0,
  "errorMsg"   => ''
];
echo json_encode($response);
