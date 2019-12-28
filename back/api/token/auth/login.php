<?php

//Loging script

//---- Requires ----
require "./../header.php";
require "functions.php";


//---- Main script ----

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(input_validation($email) && input_validation($password)){
        $user = auth_db::selectUserBy('email',$email);
        if($user != false){
            if(password_hash_check($password,$user['password'])){
                $ip = $_SERVER['REMOTE_ADDR'];
                if(!auth_db::if_ip_existed($ip)){
                    $token = generate_token();
                    $array = [
                        'token' => $token,
                        'id' => $user['id'],
                        'ip' => $ip,
                        'created_date' => strtotime('now')
                    ];
                    if(auth_db::enter_into_logged_in($array) != false){
                        $result = [
                            'result' => [
                                'done' => true,
                                'username' => $user['username'],
                                'token' => $token
                            ]
                        ];
                    }
                }
                else{
                    $result = [
                        'result' => [
                            'done' => false,
                            'error' => "this ip is logged in"
                        ]
                    ];
                }
            }
            else{
                $result = [
                    'result' => [
                        'done' => false,
                        'error' => "ایمیل یا کلمه عبور اشتباه وارد شده است"
                    ]
                ];
            }
        }
        else{
            $result = [
                'result' => [
                    'done' => false,
                    'error' => "ایمیل یا کلمه عبور اشتباه وارد شده است"
                ]
            ];
        }
    }
    else{
        $result = [
            'result' => [
                'done' => false,
                'error' => "استفاده از علائم غیر مجاز"
            ]
        ];
    }
}
else{
    $result = [
        'result' => [
            'done' => false,
            'error' => "No data sent"
        ]
    ];
}

echo json_encode($result);


?>