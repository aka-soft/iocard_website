<?php

//Selecting orders of user script

//---- Requires ----
require "functions.php";
require "./../header.php";
require_once "response_codes.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $orders = auth_db::select_orders($logged_in_token);
    if($orders !== false){
        $result = [
            'result' => [
                'done' => true,
                'logged_in' => true,
                'orders' => $orders,
                'code' => $response_codes['DONE']
            ]
        ];
    }
    else{
        $result = [
            'result' => [
                'done' => false,
                'logged_in' => true,
                'message' => "Fetching Data Failed",
                'code' => $response_codes['DB_ERROR']
            ]
        ];
    }
}
else{
    $result = [
        'result' => [
            'done' => false,
            'logged_in' => false,
            'message' => "User's not logged in",
            'code' => $response_codes['NOT_LOGGED_IN']
        ]
    ];
}

echo json_encode($result);

?>