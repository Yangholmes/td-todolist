<?php

header("Access-Control-Allow-Origin:*"); // cross domain

require_once(__DIR__.'/../../php/api/Auth.php');

$auth = new Auth(DEV_MODE);  // debug: 1表示本地调试；0表示远程服务器。使用本地调试时，请注意修改config文件
echo json_encode($auth->get_signature());
