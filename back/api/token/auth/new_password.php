<?php

require "functions.php";

$email = $_GET['email'];
$token = $_GET['rsp_token'];
$result = auth_db::select_from_rsp_token($token,$email);

if($result){
    if(date_check('rsp',$result['created_date'])){
        $result = [
            "result" => [
                'done' => true
            ]
        ];
    }
    else{
        $result = [
            "result" => [
                'done' => false
            ]
        ];
    }
}
$result = [
    "result" => [
        'done' => false
    ]
];

echo json_encode($result);

?>