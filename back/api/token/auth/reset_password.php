<?php

//Reset password script

//---- Requires ----
require "functions.php";

$email = $_POST['email'];
$password = $_POST['password'];
$result = auth_db::select_from_rsp_token($token,$email);

$hashed_password = password_encryption($password);
if(auth_db::reset_password($email,$password)){
    $result = [
        'result' => [
            'done' => true,
            'message' => 'new password is set'
        ]
    ];
}
else{
    $result = [
        'result' => [
            'done' => true,
            'message' => 'new password is set'
        ]
    ];
}

echo json_encode($result);

?>