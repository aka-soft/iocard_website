<?php

//Checks if user is logged in

//---- Requires ----
require "functions.php";
require_once "./../header.php";
require_once "response_codes.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
$user = auth_db::selectUserByToken($logged_in_token);
if($user !== false){
    $result = [
        "result" => [
            "done" => true,
            "logged_in" => true,
            "code" => $response_codes['DONE']
        ]
    ];
}
else{
    $result = [
        "result" => [
            "done" => false,
            "logged_in" => false,
            "code" => $response_codes['NOT_LOGGED_IN']
        ]
    ];
}

echo json_encode($result);

?>