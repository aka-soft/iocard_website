<?php

//---- Requires ----
require __DIR__ . "./../database/main_db.php";

//---- Authentication Database Class ----
class auth_db{

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

    //-------- Private Functions ---------
    private static function ticket_status_decoder(string $status_code){
        switch($status_code){
            case "W": return "در انتظار پاسخ"; break;
            case "A": return "پاسخ داده شد"; break;
            case "C": return "بسته شده"; break;
        }
    }



    //-------- Insert Functions ---------
    //Inserts into users table
    public static function enter_user(array $data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO users (username,email,password,token,is_active,is_partner,partner_code,date) values (?,?,?,?,?,?,?,?)");
        $insert->bind_param("ssssssss",$data['username'],$data['email'],$data['password'],$data['token'],$data['is_active'],$data['is_partner'],$data['partner_code'],$data['date']);
        $insert->execute();
        $conn->close();
    }

    //Inserts into logged_in table
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

    //Inserts into rsp table
    public static function enter_into_rsp($data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO rsp_token(rsp_token,email,created_date) VALUES (?,?,?)");
        $insert->bind_param("sss",$data['rsp_token'],$data['email'],$data['created_date']);
        $insert->execute();
        $conn->close();
    }


    public static function enter_into_tickets($data){
        $conn = self::connect();
        $insert = $conn->prepare("INSERT INTO support_tickets(user_id,subject,description,pic,status) VALUES (?,?,?,?,?)");
        $insert->bind_param('issss',$data['user_id'],$data['subject'],$data['description'],$data['pic'],$data['status']);
        if($insert->execute()){
            $conn->close();
            return true;
        }
        $conn->close();
        return false;
    }


    //-------- Validation Checks --------
    //Checks if email exists
    public static function if_email_existed($table_name,$email){
        $conn = self::connect();
        $query = "SELECT * FROM $table_name WHERE email='$email'";
        $result = $conn->query($query);
        if($result){
            if($result->num_rows > 0){
                $conn->close();
                return true;
            }
            $conn->close();
            return false;
        }
        $conn->close();
        return false;
    }

    //Checks if username exists
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

    //Checks if ip exits
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

    //Checks if account is active
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

    //Checks if user token exists
    public static function if_user_token_existed($user_token){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE token='$user_token'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }



    //--------- Selection Functions ----------
    //Selects user by a specific filter
    public static function selectUserBy($filter,$value){
        $conn = self::connect();
        $query = "SELECT * FROM users WHERE $filter='$value'";
        if($result = $conn->query($query)){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $array = [
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'email' => $row['email'],
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

    //Returns token by IP
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

    //Returns IP by token
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

    //Selects user by token
    public static function selectUserByToken($token){
        $conn = self::connect();
        $query = "SELECT * FROM logged_in WHERE token='$token'";
        $result = $conn->query($query);
        if($result){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $uid = $row['user_id'];
                }
                $query = "SELECT * FROM users WHERE id='$uid'";
                $result = $conn->query($query);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    $row['password'] = null;
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
        
    }

    //Selects data from rsp_token table
    public static function select_from_rsp_token($token,$email){
        $conn = self::connect();
        $query = "SELECT * FROM rsp_token WHERE rsp_token='$token' AND email='$email'";
        $result = $conn->query($query);
        if($result){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $array = [
                        "id" => $row['id'],
                        "rsp_token" => $row['rsp_token'],
                        "email" => $row['email'],
                        "created_date" => $row['created_date']
                    ];
                    $conn->close();
                    return $array;
                }
            }
            $conn->close();
            return false;
        }
        $conn->close();
        return false;
    }

    //Selects orders
    public static function select_orders($token){
        $orders = [];
        $user = self::selectUserByToken($token);
        if($user === false){
            return false;
        }
        $id = $user['id'];
        $conn = self::connect();
        $query = "SELECT * FROM orders WHERE orders.user_id = '$id'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $product_id = $row['product_id'];
                $product = iocard_database::select_product($product_id);
                if($product != false){
                    $product_name = $product['name'];
                    $product_link = "https://iocard.ir/products/.../product.php?id=" . $product_id; 
                }
                else{
                    $product_name = "این محصول دیگر موجود نمی باشد";
                }
                $array = [
                    'order_id' => $row['order_id'],
                    'link' => $row['link'],
                    'product_name' => $product_name,
                    'national_code' => $row['national_code'],
                    'zip_code' => $row['zip_code'],
                    'email' => $row['email'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'nickname' => $row['nickname'],
                    'country' => $row['country'],
                    'city' => $row['city'],
                    'address' => $row['address'],
                    'phone' => $row['phone'],
                    'mobile' => $row['mobile'],
                    'map_cordinates' => $row['map_cordinates'],
                    'job' => $row['job'],
                    'photo' => $row['photo'],
                    'about_me' => $row['about_me'],
                    'website' => $row['website'],
                    'social_media' => $row['social_media'],
                    'deliver_full_name' => $row['deliver_full_name'],
                    'deliver_city' => $row['deliver_city'],
                    'deliver_address' => $row['deliver_address'],
                    'deliver_zip_code' => $row['deliver_zip_code'],
                    'deliver_mobile' => $row['deliver_mobile'],
                    'deliver_phone' => $row['deliver_phone'],
                    'quantity' => $row['quantity']
                ];
                if(isset($product_link)){
                    $array['product_link'] = $product_link;
                }
                if(isset($row['partner_code']) || $row['partner_code'] != NULL){
                    $array['partner_code'] = $row['partner_code'];
                }
                array_push($orders,$array);
            }
        }
        $conn->close();
        return $orders;
    }
    

    //Selects from support tickets
    public static function select_tickets(string $logged_in_token){
        $tickets = [];
        $user = self::selectUserByToken($logged_in_token);
        $id = $user['id'];
        if($user === false){
            return false;
        }
        $conn = self::connect();
        $query = "SELECT * FROM support_tickets WHERE user_id = '$id' AND sender = 'user' AND status != 'R' AND reply_to = null";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $array = [
                    "ticket_id" => $row['ticket_id'],
                    "user_id" => $row['user_id'],
                    "subject" => $row['subject'],
                    "description" => $row['description'],
                    "pic" => $row['pic'],
                    "status" => self::ticket_status_decoder($row['status']),
                    "created_date" => $row['created_date'],
                    "modified_date" => $row['modified_date']
                ];
                array_push($tickets,$array);
            }
            $conn->close();
            return $tickets;
        }
        $conn->close();
        return false;
    }

     //Selects a specific ticket
     public static function select_ticket(string $logged_in_token,$ticket_id){
        $user = self::selectUserByToken($logged_in_token);
        $id = $user['id'];
        if($user === false){
            return false;
        }
        $conn = self::connect();
        $query = "SELECT * FROM support_tickets WHERE user_id = '$id' AND sender = 'user' AND status != 'R' AND reply_to = null AND ticket_id = '$ticket_id'";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $ticket = [
                "ticket_id" => $row['ticket_id'],
                "user_id" => $row['user_id'],
                "subject" => $row['subject'],
                "description" => $row['description'],
                "pic" => $row['pic'],
                "status" => self::ticket_status_decoder($row['status']),
                "created_date" => $row['created_date'],
                "modified_date" => $row['modified_date'],
                "replies" => []
            ];
            $query = "SELECT * FROM support_tickets WHERE user_id = '$id' AND status = 'R' AND reply_to = '$ticket_id'";
            $r_result = $conn->query($query);
            if($r_result->num_rows > 0){
                while($r_row = $r_result->fetch_assoc()){
                    $array = [
                        "ticket_id" => $r_row['ticket_id'],
                        "user_id" => $r_row['user_id'],
                        "subject" => $r_row['subject'],
                        "description" => $r_row['description'],
                        "pic" => $r_row['pic'],
                        "created_date" => $r_row['created_date'],
                    ];
                    array_push($ticket["replies"],$array);
                }
            }
        }
        $conn->close();
        return false;
            
    }

    public static function select_partner_orders($logged_in_token){
        $orders = [];
        $user = self::selectUserByToken($logged_in_token);
        if($user === false){
            return false;
        }
        if($user['is_partner']){
            $partner_code = $user['partner_code'];
            $conn = self::connect();
            $query = "SELECT * FROM orders WHERE partner_code = '$partner_code'";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($orders,$row);
                }
            }
            return $orders;
        }
        return false;
    }
    
    //---------- Deleting Functions -----------
    //Deletes from a table
    public static function delete_from($table_name,$filter,$value){
        $conn = self::connect();
        $query = "DELETE FROM $table_name WHERE $filter='$value'";
        $conn->query($query);
        $query = "SELECT * FROM $table_name WHERE $filter='$value'";
        $result = $conn->query($query);
        if($result){
            if($result->num_rows > 0){
                $conn->close();
                return false;
            }
            $conn->close();
            return true;
        }
    }

   

    //---------- Updating functions ------------
    //activates an account
    public static function set_active($user_token){
        $conn = self::connect();
        $query = "UPDATE users SET is_active=1 WHERE token='$user_token'";
        $conn->query($query);
        $conn->close();
    }

    //Resets password
    public static function reset_password($email,$hashed_password){
        $conn = self::connect();
        $update = $conn->prepare("UPDATE users SET password='?' WHERE email='?'");
        $update->bind_param("ss",$hashed_password,$email);
        $result = $update->execute();
        if($result){
            $conn->close();
            return true;
        }
        $conn->close();
        return false; 
    }

    
}



?>