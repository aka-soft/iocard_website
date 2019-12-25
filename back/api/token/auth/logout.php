<?php

//Logout script

//---- Requires ----
require "./../header.php";
require "functions.php";


//---- Main script ----
if(isset($_POST['token'])){
    $token = $_POST['token'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if(checkUserValidation($token,$ip)){
        if(auth_db::remove_from_logged_in($token)){
            $result = [
                'result' => [
                    'done' => true
                ]
            ];
        }
        else{
            $result = [
                'result' => [
                    'done' => false
                ]
            ];
        }
    }
    else{
        $result = [
            'result' => [
                'done' => false,
                'error' => 'IP is not same'
            ]
        ];
    }

    echo json_encode($result);
}


?>