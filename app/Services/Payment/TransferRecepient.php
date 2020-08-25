<?php

namespace App\Services;

use App\Services\InitiateTransfer;

class TransferRecepient
{

    protected $initiateTransfer;

    public function __construct(InitiateTransfer $initiateTransfer){
        $this->initiateTransfer = $initiateTransfer;
    }

    /*
    *   This generate the recepient code to receive the transaction
    */
    public function execute($response, $data)
    {  
        $url = "https://api.paystack.co/transferrecipient";
        $fields = [
          "type" => "nuban",
          "name" => $response['data']['account_name'],
          "description" => "Zombier",
          "account_number" => $response['data']['account_number'],
          "bank_code" => "058",
          "currency" => "NGN"
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

        // Save the recipient_code key to the user making this request

        return $this->initiateTransfer->execute($response, $data);
    }

}