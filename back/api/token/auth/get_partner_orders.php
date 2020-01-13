<?php

//Getting partner customers
//---- Requires ----
require "./functions.php";
require_once "./../header.php";
require_once "./response_codes.php";

//---- Main Script -----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    if(auth_functions::is_partner($logged_in_token)){
        $orders = auth_db::select_partner_orders($logged_in_token);
        if($orders !== false){
            $result = [
                "result" => [
                    "done" => true,
                    "orders" => $orders,
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
                "message" => "USER IS NOT PARTNER",
                "code" => $response_codes['NOT_PARTNER']
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

echo json_encode($result);

?>