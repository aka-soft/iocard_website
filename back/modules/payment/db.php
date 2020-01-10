<?php

//---- Payment Database Functions
//---- Requires ----
require "./../../database/main_db.php";

//---- Main Class ----
class payment_db{

    function __construct()
    {
        
    }


    //---- database connection method ----
    private static function connect(){
        $connection = new mysqli(hostname,username,password,dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else{
            return $connection;
        }
    }

    //---- status decoder method ----
    private static function status_decoder($status){
        switch($status){
            case 'N': return "پرداخت نشده"; break;
            case 'C': return "کنسل شده"; break;
            case 'U': return "ناموفق"; break;
            case 'P': return "پرداخت شده"; break;
        }
    }

    //---- insert into database ----
    public static function insert_into_db(array $data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO payments (user_id,order_id,amount,status) VALUES (?,?,?,?)");
        $insert->bind_param("iiis",$data['user_id'],$data['order_id'],$data['amount'],$data['status']);
        $result = $insert->execute();
        if($result){
            $conn->close();
            return true;
        }
        $conn->close();
        return false;
    }

    public static function update_status(string $status,$refid,$user_id){
        $conn = self::connect();
        $update = $conn->prepare("UPDATE payments refId='?', status='?' WHERE user_id='?'");
        $update->bind_param("ssi",$refid,$status,$user_id);
        $result = $update->execute();
        if($result){
            $conn->close();
            return true;
        }
        $conn->close;
        return false;
    }

}

?>