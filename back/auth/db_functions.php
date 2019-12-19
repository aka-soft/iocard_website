<?php

require "../config.php";

class database{

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
        $insert = $conn->prepare("INSERT INTO users (username,email,password,token,is_active,is_partner,date) values (?,?,?,?,?,?,?)");
        $insert->bind_param("ssssiis",$data['username'],$data['email'],$data['password'],$data['token'],$data['is_active'],$data['is_partner'],$data['date']);
        $insert->execute();
        $conn->close();
    }

}

?>