<?php

//---- Partner Payment page ----
//---- Requires ----
require "./functions.php";
require "./../../../modules/payment/payment.php";
require_once "./response_codes.php";
require_once "./../header.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $user = auth_db::selectUserByToken($logged_in_token);
    if($user !== false){
        if(!auth_functions::is_partner($logged_in_token)){
            $user_id = $user['id'];
            $email = $user['email'];
            $amount = $_POST['amount'];
            $return_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $order_id = 0;
            payment::paymentRequest($amount,$email,$user_id,$order_id,$return_url);
        }
        else{
            $result = [
                "result" => [
                    "done" => false,
                    "message" => "IS PARTNER",
                    "code" => $response_codes['IS_PARTNER']
                ]
            ];
        }
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