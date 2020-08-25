<?php

namespace App\Services;

use App\Services\TransferRecepient;


class VerifyAccount
{

    protected $transferRecepient;

    public function __construct(TransferRecepient $transferRecepient){
        $this->transferRecepient = $transferRecepient;

    }

    /*
    *   Verify the account number
    */
    public function execute(array $data)
    {
        $accountNumber = $data['account_number'];

    	// Let's store the amount received from the customer
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$accountNumber."&bank_code=058",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);

        if ($err) {
            return  "cURL Error #:" . $err;
        } 
        
        $response = json_decode($response, true);
        
        return $this->transferRecepient->execute($response, $data);
    }

}