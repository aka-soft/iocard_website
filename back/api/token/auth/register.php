<?php

//Registeration script

//---- Requires ----
require "./../header.php";
require "./../../db.php";

//---- functions ----
function input_validation($password){
    return true;
}

function generate_token(){
    return bin2hex(openssl_random_pseudo_bytes(40));
}

function generate_salt($length){
    $unique_random_string = md5(uniqid(mt_rand(),true));
    $base64_encoded = base64_encode($unique_random_string);
    $modified = str_replace('+','.',$base64_encoded);
    $salt = substr($modified,0,$length);
    return $salt;
}

function password_encryption($password){
    $blowfish_hash_format = "$2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $blowfish_with_salt = $blowfish_hash_format . $salt;
    $hash = crypt($password,$blowfish_with_salt);
    return $hash;
}

//main script

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(input_validation($username) && input_validation($password)){
        if(!auth_db::if_email_existed($email)){
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