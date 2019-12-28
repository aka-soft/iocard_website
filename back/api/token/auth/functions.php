<?php

//Some private functions

//---- Requires ----
require_once "./../../db.php";

//---- Functions ----
function checkTokenIp($token,$ip){
    $existing_ip = auth_db::return_ip_by_token($token);
    if($existing_ip == $ip){
        return true;
    }
    return false;
}

function if_active($token){
    $user = auth_db::selectUserByToken($token);
    $active = $user['is_active'];
    if($active){
        return true;
    }
    return false;
}

function checkUserValidation($token,$ip){
    if(if_active($token)){
        if(checkTokenIp($token,$ip)){
            return true;
        }
        return false;
    }
    return false;
}

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

function password_hash_check($password,$hash){
    if(crypt($password,$hash) == $hash){
        return true;
    }
    return false;
}

function send_activation_email($user_token,$email){
    $to = $email;
    $from = "YOUR EMAIL ADDRESS";
    $subject = "فعالسازی حساب کاربری";
    $message = "کاربر عزیز، با تشکر از عضویت شما در وبسایت آیوکارد، جهت تکمیل عملیات عضویت خود، برای فعال کردن حساب کاربریتان بر روی لینک زیر کلیک  کنید";
    $message .= "<br><br>https://iocard.ir/account/activate.php?token=$user_token";
    mail($to,$subject,$message,$from); 
}

function send_rsp_email($rsp_token,$email){
    $to = $email;
    $from = "YOUR EMAIL ADDRESS";
    $subject = "تغییر کلمه عبور";
    $message = "کاربر عزیز! جهت تغییر کلمه عبور خود بر روی لینک زیر کلیک کنید و اگر این پیام به درخواست شما ارسال نشده است آن را نادیده بگیرید";
    $message .= "<br><br>https://iocard.ir/account/rsp.php?token=$rsp_token&&email=$email";
    mail($to,$subject,$message,$from); 
}


function date_check($type,$date){
    switch($type){
        case 'rsp':
            if(strtotime('now') > ($date+3600)){
                return false;
            }
            return true;
        break;
        case 'logged_in':
            if(strtotime('now') > ($date+86400)){
                return false;
            }
            return true;
    }
}

?>