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

}

?>