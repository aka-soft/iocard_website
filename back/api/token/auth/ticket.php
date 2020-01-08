<?php

//Getting ticket
//---- Requires ----
require "./functions.php";
require_once "./../header.php";
require_once "./response_codes.php";

//---- Main Script ----
$ticket_id = $_GET['id'];
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $ticket = auth_db::select_ticket($logged_in_token,$ticket_id);
    if($ticket !== false){
        $result = [
            "result" => [
                "done" => true,
                "ticket" => $ticket,
                "code" => $response_codes['DONE']
            ]
        ];
    }
    else{
        $result = [
            "result" => [
                "done" => false,
                "message" => "TICKET NOT FOUND",
                "code" => $response_codes['TICKET_NOT_FOUND']
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