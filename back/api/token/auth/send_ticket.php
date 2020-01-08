<?php

//Sending support tickets script

//---- Requires ----
require "functions.php";
require_once "./../header.php";
require_once "./response_codes.php";

//---- Main Program ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $user = auth_db::selectUserByToken($logged_in_token);
    $user_id = $user['id'];
    $pic = null;
    $date = getdate();
    $now_date = $date['year'] . "/" . $date['mon'] . "/" . $date['mday'];
    if(isset($_FILES['userfile'])){
        $pic = auth_functions::savePic("support",$_FILES['userfile']);
    }
    if($pic !== false){
        $data = [
            "user_id" => $user_id,
            "subject" => $subject,
            "description" => $description,
            "pic" => $pic,
            "status" => "A",
            "created_date" => $now_date,
            "modified_date" => $now_date,
            "replied_to" => null,
            "sender" => "user"
        ];
        if(auth_db::enter_into_tickets($data)){
            $result = [
                "result" => [
                    "done" => true,
                    "message" => "TICKET SUBMITTED",
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
                "message" => "UPLOAD PROBLEMS",
                "code" => $response_codes['UPLOAD_PROB']
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