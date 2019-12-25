<?php

require "functions.php";

$ip = $_SERVER['REMOTE_ADDR'];
$token = $_POST['token'];
auth_db::set_active($token);

?>