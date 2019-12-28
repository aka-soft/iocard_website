<?php

//Registeration script
//!!!!MAIL SYSTEM NOT DEVELOPED

//---- Requires ----
require "./../header.php";
require "functions.php";


//main script

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(input_validation($username) && input_validation($password)){
        if(!auth_db::if_email_existed('users',$email)){
            if(!auth_db::if_username_existed($username)){
                $token = generate_token();
                $hashed_password = password_encryption($password);
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
                $message = "User registered";
                //send_activation_email($token,$email);
            }
            else{
                $done = false;
                $message = "This username has been used";
            }
        }
        else{
            $done = false;
            $message = "This email has been used";
        }    
    }
    else{
        $done = false;
        $message = "Using of illegal signs";
    }
    
    $result = [
        "result" => [
            "done" => $done,
            "message" => $message
        ]
    ];    
}
else{
    $done = false;
    $message = "data not sent";
    $result = [
        "result" => [
            "done" => $done,
            "message" => $message
        ]
    ];
}


print json_encode($result);

?>