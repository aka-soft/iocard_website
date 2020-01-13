<?php

//Checks if re$result is logged in

//---- Requires ----
require "functions.php";
require_once "./../header.php";
require_once "response_codes.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
$result_l = auth_functions::logged_in($logged_in_token);
if($result_l){
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