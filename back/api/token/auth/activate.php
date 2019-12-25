<?php

//Account activation script
//---- Requires ----
require "./../../db.php";

//---- Main Script ----
$user_token = $_GET['token'];
if(auth_db::if_user_token_existed($user_token)){
    if(!auth_db::check_activation($user_token)){
        auth_db::set_active($user_token);
        //UI
    }
}
//UI


?>