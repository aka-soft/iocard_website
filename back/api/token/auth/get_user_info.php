<?php

//Returns user information
//---- Requires ----
require "./functions.php";
require_once "./../header.php";
require_once "./response_codes.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $user_info = auth_db::select_user_info($logged_in_token);
    if($user_info !== false){
        $result = [
            "result" => [
                "done" => true,
                "user_info" => $user_info,
                "code" => $response_codes['DONE']
            ]
        ];
    }
    else{
        $result = [
            "result" => [
                "done" => false,
                "message" => "DATABASE ERROR",
                "code" => $response_codes['DB_ERROR']
            ]
        ];
    }
}
else{
    $result = [
        "result" => [
            "done" => false,
            "message" => "NOT LOGGED IN",
            "code" => $response_codes['NOT_LOGGED_IN']
        ]
    ];
}
 
?>