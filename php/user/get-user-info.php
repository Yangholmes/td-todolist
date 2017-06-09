<?php

require_once( __DIR__.'/../../php/api/Auth.php');
require_once( __DIR__.'/../../php/api/User.php');


$accessToken = $_GET['access_token'];
$code = $_GET['code'];

/**
 * get user info
 */
$user = new User();
$userInfo = $user->getUserInfo($accessToken, $code);

echo $userInfo;

/**
 * update user table
 */
require_once( './update-user-info.php');
updateUserInfo($userInfo);
