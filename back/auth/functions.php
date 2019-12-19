<?php

class auth{

    function __construct(){}

    public static function password_validation($password){
        $lower_ab = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $upper_ab = ['A','B','C','D','E','F','G','H','I','J','K','L','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        if(strlen($password) < 8){
            $_SESSION['message'] = "کلمه عبور باید بیش از 8 کاراکتر باشد";
            return false;
        }
        if(!preg_match("/[a-z]/i", $password)){
            $_SESSION['message'] = "کلمه عبور باید شامل حداقل یک حرف باشد";
            return false;
        }

    }

    private static function generate_salt($length){
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

    public static function generate_token(){
        return bin2hex(openssl_random_pseudo_bytes(40));
    }

    
}

?>