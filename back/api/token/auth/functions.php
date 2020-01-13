<?php

//---- Requires ----
require_once "./../../db.php";

//---- Authentication Functions ----
class auth_functions{
    public static function checkTokenIp($token,$ip){
        $existing_ip = auth_db::return_ip_by_token($token);
        if($existing_ip == $ip){
            return true;
        }
        return false;
    }
    
    public static function if_active($token){
        $user = auth_db::selectUserByToken($token);
        $active = $user['is_active'];
        if($active){
            return true;
        }
        return false;
    }
    
    public static function checkUserValidation($token,$ip){
        if(self::if_active($token)){
            if(self::checkTokenIp($token,$ip)){
                return true;
            }
            return false;
        }
        return false;
    }
    
    public static function input_validation($password){
        return true;
    }
    
    public static function generate_token(){
        return bin2hex(openssl_random_pseudo_bytes(40));
    }
    
    public static function generate_salt($length){
        $unique_random_string = md5(uniqid(mt_rand(),true));
        $base64_encoded = base64_encode($unique_random_string);
        $modified = str_replace('+','.',$base64_encoded);
        $salt = substr($modified,0,$length);
        return $salt;
    }
    
    public static function password_encryption($password){
        $blowfish_hash_format = "$2y$10$";
        $salt_length = 22;
        $salt = self::generate_salt($salt_length);
        $blowfish_with_salt = $blowfish_hash_format . $salt;
        $hash = crypt($password,$blowfish_with_salt);
        return $hash;
    }
    
    public static function password_hash_check($password,$hash){
        if(crypt($password,$hash) == $hash){
            return true;
        }
        return false;
    }
    
    public static function send_activation_email($user_token,$email){
        $to = $email;
        $from = "YOUR EMAIL ADDRESS";
        $subject = "فعالسازی حساب کاربری";
        $message = "کاربر عزیز، با تشکر از عضویت شما در وبسایت آیوکارد، جهت تکمیل عملیات عضویت خود، برای فعال کردن حساب کاربریتان بر روی لینک زیر کلیک  کنید";
        $message .= "<br><br>https://iocard.ir/account/activate.php?token=$user_token";
        mail($to,$subject,$message,$from); 
    }
    
    public static function send_rsp_email($rsp_token,$email){
        $to = $email;
        $from = "YOUR EMAIL ADDRESS";
        $subject = "تغییر کلمه عبور";
        $message = "کاربر عزیز! جهت تغییر کلمه عبور خود بر روی لینک زیر کلیک کنید و اگر این پیام به درخواست شما ارسال نشده است آن را نادیده بگیرید";
        $message .= "<br><br>https://iocard.ir/account/rsp.php?token=$rsp_token&email=$email";
        mail($to,$subject,$message,$from); 
    }
    
    
    public static function date_check($type,$date){
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
    
    public static function password_confirmed($password,$re_password){
        if($password == $re_password){
            return true;
        }
        return false;
    }

    public static function logged_in($token){
        $logged_in_token = $token;
        if(!self::checkUserValidation($logged_in_token,$_SERVER['REMOTE_ADDR'])){
            return false;
        }
        $user = auth_db::selectUserByToken($logged_in_token);
        $rsp_row = auth_db::select_from_rsp_token($logged_in_token,$user['email']);
        if($rsp_row !== false){
            $date = $rsp_row['created_date'];
            if(self::date_check("logged_in",$date)){
                if($user !== false){
                    if($user['is_active']){
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public static function CheckPicValidation($file){
        $size = $file['size'];
        $e_file = explode(".",$file['name']);
        $valid_formats = ["jpg","jpeg","png"];
        if($size > 2000){
            return false;
        }
        if(sizeof($e_file) > 2){
            return false;
        }
        if(!in_array($e_file[1],$valid_formats)){
            return false;
        }
        return true;
    }

    public static function savePic(string $type,$file){
        $base_dir = "BASE DIR";
        switch($type){
            case "support":
                if(self::CheckPicValidation($file)){
                    $upload_file = $base_dir . "/support/" . basename($file['name']);
                    if(move_uploaded_file($file['tmp_name'],$upload_file)){
                        return $upload_file;
                    }
                    else{
                        return false;
                    }
                }
                return false;
            break;
            case "user_info":
                if(self::CheckPicValidation($file)){
                    $upload_file = $base_dir . "/users/" . basename($file['name']);
                    if(move_uploaded_file($file['tmp_name'],$upload_file)){
                        return $upload_file;
                    }
                    else{
                        return false;
                    }
                }
                return false;
        }
    }

    public static function is_partner($logged_in_token){
        $user = auth_db::selectUserByToken($logged_in_token);
        if($user === false){
            return false;
        }
        if($user['is_partner']){
            return true;
        }
        return false;
    }
}

?>