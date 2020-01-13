<?php

//---- Defining constant configs ----
define("hostname","localhost");
define("username","root");
define("password","");
define("dbname","iocard_db");

//---- Main Database Class ----

class iocard_database{

    //Constructor
    function __construct(){}

    //Database connector
    private static function connect(){
        $connection = new mysqli(hostname,username,password,dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        else{
            return $connection;
        }
    }

    //---- Selection Functions ----
    //Selecting product
    public function select_product($id){
        $conn = self::connect();
        $query = "SELECT * FROM products WHERE id='$id'";
        $result = $conn->query($query);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                //Returns product
            }
        }
        else{
            $conn->close();
            return false;
        }
    }
}

?>