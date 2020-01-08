<?php

//Registeration script
//!!!!MAIL SYSTEM NOT DEVELOPED

//---- Requires ----
require "./../header.php";
require "functions.php";
require_once "response_codes.php";

//main script

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['confirm_password'])){

    $result = [];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    if(auth_functions::password_confirmed($password,$re_password)){
        if(auth_functions::input_validation($username) && auth_functions::input_validation($password)){
            if(!auth_db::if_email_existed('users',$email)){
                if(!auth_db::if_username_existed($username)){
                    $token = auth_functions::generate_token();
                    $hashed_password = auth_functions::password_encryption($password);
                    $is_active = 1;
                    $is_partner = 0;
                    $partner_code = "PC_" . bin2hex(openssl_random_pseudo_bytes(3));
                    $date = getdate()['year'] . "/" . getdate()['mon'] . "/" . getdate()['mday'];
                    $data = [
                        "username" => $username,
                        "email" => $email,
                        "password" => $hashed_password,
                        "token" => $token,
                        "is_active" => $is_active,
                        "is_partner" => $is_partner,
                        "partner_code" => $partner_code,
                        "date" => $date
                    ];
                    auth_db::enter_user($data);
                    $done = true;
                    $message = "USER REGISTERED";
                    $code = $response_codes['DONE'];
                    //send_activation_email($token,$email);
                }
                else{
                    $done = false;
                    $message = "THIS USERNAME HAS BEEN USED";
                    $code = $response_codes['USERNAME_EXISTS'];
                }
            }
            else{
                $done = false;
                $message = "THIS EMAIL HAS BEEN USED";
                $code = $response_codes['EMAIL_EXISTS'];
            }    
        }
        else{
            $done = false;
            $message = "USING ILLEGAL CHARACTERS";
            $code = $response_codes['ILLEGAL_CHARS'];
        }
        
        $result = [
            "result" => [
                "done" => $done,
                "message" => $message,
                "code" => $code
            ]
        ];
    }
    else{
        $done = false;
        $message = "PASSWORD AND CONFIRMATION DON'T MATCH";
        $result = [
            "result" => [
                "done" => $done,
                "message" => $message,
                "code" => $response_codes['PASSWORD_AND_CONFIRMATION_NOT_MATCH']
            ]
        ];
    }    
}
else{
    $done = false;
    $message = "DATA NOT SENT";
    $result = [
        "result" => [
            "done" => $done,
            "message" => $message,
            "code" => $response_codes['DATA_NOT_SENT']
        ]
    ];
}

echo json_encode($result);

?>