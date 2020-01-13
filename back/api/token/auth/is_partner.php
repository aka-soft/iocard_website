<?php

//---- Checks if user is partner ----
//---- Requires ----
require "./functions.php";
require_once "./response_codes.php";
require_once "./../header.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    if(auth_functions::is_partner($logged_in_token)){
        $result = [
            "result" => [
                "done" => true,
                "message" => "USER IS PARTNER",
                "code" => $response_codes['DONE']
            ]
        ];
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