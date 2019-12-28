<?php

//Reset Password Email Sender
//---- Requires ----
require "./../header.php";
require "functions.php";

//---- Main Script ----
$email = $_POST['email'];
if(auth_db::if_email_existed('users',$email)){
    if(auth_db::if_email_existed('rsp_token',$email)){
        auth_db::delete_from('rsp_token','email',$email);
    }
    $rsp_token = generate_token();
    $created_date = strtotime('now');
    $data = [
        'rsp_token' => $rsp_token,
        'email' => $email,
        'created_date' => $created_date 
    ];
    auth_db::enter_into_rsp($data);
    //send_rsp_email($rsp_token,$email);
    $result = [
        'result' => [
            'done' => true,
            'message' => "ایمیل تغییر رمز عبور برای شما ارسال شد. لینک داخل ایمیل تنها یک ساعت اعتبار دارد"
        ]
    ];
}
else{
    $result = [
        'result' => [
            'done' => false,
            'message' => "آدرس ایمیل وارد شده در سیستم وجود ندارد"
        ]
    ];
}

echo json_encode($result);

?>

