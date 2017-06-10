<?php

/**
 * 获取所有task记录
 * http方法： GET
 * 2017/06/10 Yangholmes
 */

 /**
  * require libs
  */
 require_once( __DIR__.'/../../php/config/server-config.php');
 require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

 /**
  * recieve GET data
  */
$user = $_GET['user'];

//

/**
 * instance a new yangMysql class
 */
$taskQuery  = new yangMysql(); //
$taskQuery->selectDb(DB_DATABASE); //
$taskQuery->selectTable("task");

/**
 * retrieve the task
 */
$condition = "user = $user";
$tasks = $taskQuery->simpleSelect(null, $condition, ['`createDate`', 'ASC'], null);

echo json_encode($tasks);
