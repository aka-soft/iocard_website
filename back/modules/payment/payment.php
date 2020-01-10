<?php

//---- Payment Module Class
//---- Requires ----
require "./db.php";

//---- Main Class ----
class payment{

    //---- Constants ----
    private const merchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';

    //---- Constructor ----
    function __construct()
    {
        
    }

    //---- Payment Request ----
    public static function paymentRequest($amount,$email,$user_id,$order_id,$return_url){
        $callback_url = "CALLBACK URL" . "?id=" . $user_id . "&amount=" . $amount . "&return_url=" . $return_url;
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $description = "DESCRIPTION";
        $result = $client->PaymentRequest(
            [
                'MerchantID' => self::merchantID,
                'Amount' => $amount,
                'Description' => $description,
                'Email' => $email,
                'CallbackURL' => $callback_url,
            ]
        );

        $data = [
            "user_id" => $user_id,
            "order_id" => $order_id,
            "email" => $email,
            "amount" => $amount,
            "status" => "N"
        ];

        payment_db::insert_into_db($data);

        if($result->Status == 100) {
            Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
        }
        else{
            echo'ERR: '.$result->Status;
        }
    }

    public static function verify_payment($authority,$amount,$status,$user_id){
        if($status == "NOK"){
            payment_db::update_status("C",null,$user_id);
        }
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentVerification(
            [
                'MerchantID' => self::merchantID,
                'Authority' => $authority,
                'Amount' => $amount,
            ]
        );

        if($result->Status == 100) {
            payment_db::update_status("P",$result->refID,$user_id);
        } 
        else{
            payment_db::update_status("U",$result->Status,$user_id);
        }
    }
}

?>