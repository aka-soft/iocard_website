<?php

//Loging script

//---- Requires ----
require "./../header.php";
require "functions.php";
require_once "response_codes.php";

//---- Main script ----

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(auth_functions::input_validation($email) && auth_functions::input_validation($password)){
        $user = auth_db::selectUserBy('email',$email);
        if($user != false){
            if(auth_functions::password_hash_check($password,$user['password'])){
                $ip = $_SERVER['REMOTE_ADDR'];
                if(!auth_db::if_ip_existed($ip)){
                    $token = auth_functions::generate_token();
                    $array = [
                        'token' => $token,
                        'id' => $user['id'],
                        'ip' => $ip,
                        'created_date' => strtotime('now')
                    ];
                    if(auth_db::enter_into_logged_in($array) != false){
                        $result = [
                            'result' => [
                                'done' => true,
                                'username' => $user['username'],
                                'token' => $token,
                                'code' => $response_codes['DONE']
                            ]
                        ];
                    }
                }
                else{
                    $result = [
                        'result' => [
                            'done' => false,
                            'message' => "IP EXISTS",
                            'code' => $response_codes['IP_EXISTS']
                        ]
                    ];
                }
            }
            else{
                $result = [
                    'result' => [
                        'done' => false,
                        'message' => "WRONG ACCESS INFO",
                        'code' => $response_codes['WRONG_ACCESS_INFO']
                    ]
                ];
            }
        }
        else{
            $result = [
                'result' => [
                    'done' => false,
                    'message' => "WRONG ACCESS INFO",
                    'code' => $response_codes['WRONG_ACCESS_INFO']
                ]
            ];
        }
    }
    else{
        $result = [
            'result' => [
                'done' => false,
                'message' => "ILLEGAL CHARACTERS",
                'code' => $response_codes['ILLEGAL_CHARS']
            ]
        ];
    }
}
else{
    $result = [
        'result' => [
            'done' => false,
            'message' => "DATA NOT COMPLETE",
            'code' => $response_codes['DATA_NOT_COMPLETE']
        ]
    ];
}

echo json_encode($result);


?>