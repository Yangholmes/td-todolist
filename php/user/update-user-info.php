<?php

/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');
require_once( __DIR__.'/../../php/api/Auth.php');

function updateUserInfo ($user) {

  $userQuery = new yangMysql();
  $userQuery->selectDb(DB_DATABASE);
  $userQuery->selectTable("user");

  /**
   * 更新用户
   */
  $condition = "emplId='".$user['emplId']."'";
  $userResult = $userQuery->simpleSelect(null, $condition, null, null );
  if(!count($userResult)) {
    $userQuery->insert($user);
  }
  else {
    $userQuery->update($user, $condition, null, null);
  }

  return true;

}
