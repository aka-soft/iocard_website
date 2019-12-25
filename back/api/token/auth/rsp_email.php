<?php

//Reset Password Email Sender
//---- Requires ----
require "functions.php";

//---- Main Script ----
$email = $_POST['email'];
if(auth_db::if_email_existed($email)){
}

?>