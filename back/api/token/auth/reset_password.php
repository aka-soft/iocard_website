<?php

//Reset password script

//---- Requires ----
require "functions.php";
require_once "./../header.php";
require_once "response_codes.php";

$email = $_POST['email'];
$password = $_POST['password'];
$result = auth_db::select_from_rsp_token($token,$email);
$hashed_password = auth_functions::password_encryption($password);
if(auth_db::reset_password($email,$password)){
    $result = [
        'result' => [
            'done' => true,
            'message' => 'new password is set',
            'code' => $response_codes['DONE']
        ]
    ];
}
else{
    $result = [
        'result' => [
            'done' => false,
            'message' => 'new password is set',
            'code' => $response_codes['DB_ERROR']
        ]
    ];
}

echo json_encode($result);

?>