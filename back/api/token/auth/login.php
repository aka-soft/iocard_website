<?php

//Loging script

//---- Requires ----
require "./../header.php";
require "./../../db.php";

//---- function ----
function password_hash_check($password,$hash){
    if(crypt($password,$hash) == $hash){
        return true;
    }
    return false;
}

function input_validation($password){
    return true;
}


if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(input_validation($email) && input_validation($password)){
        $user = auth_db::selectUserByEmail($email);
        if($user != false){
            if(password_hash_check($password,$user['password'])){
                $result = [
                    'result' => [
                        'confirmed' => true,
                        'username' => $user['username'],
                        'token' => $user['token']
                    ]
                ];
            }
            else{
                $result = [
                    'result' => [
                        'confirmed' => false,
                        'error' => "ایمیل یا کلمه عبور اشتباه وارد شده است"
                    ]
                ];
            }
        }
        else{
            $result = [
                'result' => [
                    'confirmed' => false,
                    'error' => "ایمیل یا کلمه عبور اشتباه وارد شده است"
                ]
            ];
        }
    }
    else{
        $result = [
            'result' => [
                'confirmed' => false,
                'error' => "استفاده از علائم غیر مجاز"
            ]
        ];
    }
}
else{
    $result = [
        'result' => [
            'confirmed' => false,
            'error' => "No data sent"
        ]
    ];
}

echo json_encode($result);


?>