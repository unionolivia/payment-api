<?php

namespace App\Services;


class FinalTransfer
{

    public function __construct(){

    }

    /*
    *   Final transfer after successful transfer initiation
    */
    public function execute($response)
    {
      $url = "https://api.paystack.co/transfer/finalize_transfer";
      $fields = [
        "transfer_code" => $response['data']['transfer_code'], // "TRF_fiyxvgkh71e717b" This is test, but can be generated on real account
        "otp" => "928783" // Fake OTP
      ];
      $fields_string = http_build_query($fields);
      
      //open connection
      $ch = curl_init();
      
      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
        "Cache-Control: no-cache",
      ));
      
      //So that curl_exec returns the contents of the cURL; rather than echoing it
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
      
      //execute post
      $result = curl_exec($ch);
      
      $response = json_decode($result, true);
      
      return $response;
    }

}