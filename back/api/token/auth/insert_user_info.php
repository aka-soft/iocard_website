<?php

//---- Inserting user's information ----
//---- Requires ----
require "./functions.php";
require_once "./response_codes.php";
require_once "./../header.php";

//---- Main Script ----
$logged_in_token = $_POST['token'];
if(auth_functions::logged_in($logged_in_token)){
    $user = auth_db::selectUserByToken($logged_in_token);
    if($user !== false){
        $pic = null;
        if(isset($_FILES['userfile'])){
            if(auth_functions::savePic("user_info",$_FILES['userfile'])){
                if(!auth_functions::CheckPicValidation($_FILES['userfile'])){
                    $result = [
                        "result" => [
                            "done" => false,
                            "message" => "UPLOAD PROBLEMS",
                            "code" => $response_codes['UPLOAD_PROB']
                        ]
                    ];
                    echo json_encode($result);
                    die;
                }
                $pic = auth_functions::savePic("user_info",$_FILES['userfile']);
            }
        }
        $data = [
            'user_id' => $user['id'],
            'national_code' => $_POST['national_code'],
            'zip_code' => $_POST['zip_code'],
            'email' => $_POST['email'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'nickname' => $_POST['nickname'],
            'country' => $_POST['country'],
            'city' => $_POST['city'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'mobile' => $_POST['mobile'],
            'map_cordinates' => $_POST['map_cordinates'],
            'job' => $_POST['job'],
            'photo' => $pic,
            'about_me' => $_POST['about_me'],
            'website' => $_POST['website'],
            'social_media' => $_POST['social_media']
        ];
        if(auth_db::enter_user_info($data)){
            $result = [
                "result" => [
                    "done" => true,
                    "message" => "INFORMATION INSERTED",
                    "code" => $response_codes['DONE']
                ]
            ];
        }
        else{
            $result = [
                "result" => [
                    "done" => false,
                    "message" => "DATABASE ERROR",
                    "code" => $response_codes['DB_ERROR']
                ]
            ];
        }
    }
    else{
        $result = [
            "result" => [
                "done" => false,
                "message" => "DATABASE ERROR",
                "code" => $response_codes['DB_ERROR']
            ]
        ];
    }
}
else{
    $result = [
        "result" => [
            "done" => false,
            "message" => "NOT LOGGED IN",
            "code" => $response_codes['NOT_LOGGED_IN']
        ]
    ];
}

echo json_encode($result);

?>