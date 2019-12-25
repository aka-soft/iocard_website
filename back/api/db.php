<?php

define("hostname","localhost");
define("username","root");
define("password","");
define("dbname","iocard_db");

class auth_db{

    function __construct(){}

    private static function connect(){
        $connection = new mysqli(hostname,username,password,dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else{
            return $connection;
        }
    }

    public static function enter_user(array $data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO users (username,email,password,token,is_active,is_partner,partner_code,date) values (?,?,?,?,?,?,?,?)");
        $insert->bind_param("ssssssss",$data['username'],$data['email'],$data['password'],$data['token'],$data['is_active'],$data['is_partner'],$data['partner_code'],$data['date']);
        $insert->execute();
        $conn->close();
    }

    public static function if_email_existed($email){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE email = '$email'";
        if($result = $conn->query($query)){
            if($result->num_rows > 0){
                $conn->close();
                return true;
            }
            return false;
        }
        else{
            print $conn->error;
            $conn->close();
            return false;
        }
        
    }

    public static function if_username_existed($username){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE username = '$username'";
        if($result = $conn->query($query)){
            if($result->num_rows > 0){
                $conn->close();
                return true;
            }
            return false;
        }
        else{
            print $conn->error;
            $conn->close();
            return false;
        }
    }

    public static function selectUserByEmail($email){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE email='$email'";
        if($result = $conn->query($query)){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $array = [
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'email' => $row['email'],
                        'password' => $row['password'],
                        'token' => $row['token'],
                        'is_active' => $row['is_active'],
                        'is_partner' => $row['is_partner'],
                        'partner_code' => $row['partner_code'],
                        'date' => $row['date']
                    ];
                    return $array;
                }
            }
            else{
                return false;
            }
        }
        else{
            print $conn->error;
            $conn->close();
        }
    }

    public static function enter_into_logged_in($data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO logged_in(user_id,token,ip,created_date) VALUES (?,?,?,?)");
        $insert->bind_param("isss",$data['id'],$data['token'],$data['ip'],$data['created_date']);
        if($insert->execute()){
            $conn->close();
            return true;
        }
        else{
            $error = $conn->error;
            $conn->close();
            return $error;
        }
    }

    public static function if_ip_existed($ip){
        $conn = self::connect();
        $query = "SELECT * FROM logged_in WHERE ip='$ip'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            $conn->close();
            return true;
        }
        $conn->close();
        return false;
    }

    public static function remove_from_logged_in($token){
        $conn = self::connect();
        $query = "DELETE FROM logged_in WHERE token='$token'";
        $conn->query($query);
        $query = "SELECT * FROM logged_in WHERE token='$token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            $conn->close();
            return false;
        }
        else{
            $conn->close();
            return true;
        }
    }

    public static function return_token_by_ip($ip){
        $conn = self::connect();
        $query = "SELECT * FROM logged_in WHERE ip='$ip'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $token = $row['token'];
                $conn->close();
                return $token;
            }
        }
        $conn->close();
        return false;
    }

    public static function return_ip_by_token($token){
        $conn = self::connect();
        $query = "SELECT * FROM logged_in WHERE token='$token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $ip = $row['ip'];
                $conn->close();
                return $ip;
            }
        }
        $conn->close();
        return false;
    }

    public static function selectUserByToken($token){
        $conn = self::connect();
        $query = "SELECT * FROM logged_in WHERE token='$token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $uid = $row['user_id'];
            }
            $query = "SELECT * FROM users WHERE id='$uid'";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $conn->close();
                return $row;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        
    }

    public static function set_active($user_token){
        $conn = self::connect();
        $query = "UPDATE users SET is_active=1 WHERE token='$user_token'";
        $conn->query($query);
        $conn->close();
    }

    public static function check_activation($user_token){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE token='$user_token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['is_active']){
                    $conn->close();
                    return true;
                }
                $conn->close();
                return false;
            }
        }
    }

    public static function if_user_token_existed($user_token){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE token='$user_token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

}

?>