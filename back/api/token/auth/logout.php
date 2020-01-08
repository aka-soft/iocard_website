<?php

//Logout script

//---- Requires ----
require "./../header.php";
require "functions.php";
require_once "response_codes.php";

//---- Main script ----
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if(auth_functions::checkUserValidation($token,$ip)){
        if(auth_db::delete_from('logged_in','token',$token)){
            $result = [
                'result' => [
                    'done' => true,
                    'code' => $response_codes['DONE']
                ]
            ];
        }
        else{
            $result = [
                'result' => [
                    'done' => false,
                    'message' => "DATABASE ERROR",
                    'code' => $response_codes['DB_ERROR']
                ]
            ];
        }
    }
    else{
        $result = [
            'result' => [
                'done' => false,
                'message' => 'NOT LOGGED IN',
                'code' => $response_codes['NOT_LOGGED_IN']
            ]
        ];
    }

    echo json_encode($result);
}


?>