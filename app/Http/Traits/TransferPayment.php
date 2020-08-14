<?php
namespace App\Http\Traits;

trait TransferPayment {

	/*
    *	Let's verify the account Number
    */
    public function verifyAccountNumber($accountNumber)
    {
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
	return $response;
    }
    
    
    /*
    *  This generate the recepient code to receive the transaction
    */
    public function recepientTransfer($accountNumber){
    	
    	$url = "https://api.paystack.co/transferrecipient";
	  $fields = [
	    "type" => "nuban",
	    "name" => "Zombie",
	    "description" => "Zombier",
	    "account_number" => $accountNumber,
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
	  
	  
	  if($response['status'] == false){
	  	return response()->json([
	       'result' => 'Unable to handle the request at the moment',
	     ], 500);
	  }
	  
	  return $response;
	    
    }
    
    
     /*
    *	Initial transfer money to a recepient
    */
    public function initiatingTransfer($response, $data){
    
	  $url = "https://api.paystack.co/transfer";
	  $fields = [
	    "source" => "balance", 
	    "reason" => $data['reason'], 
	    "amount" => $data['amount'], 
	    "recipient" => $response['data']['recipient_code']
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
	  
	  // If response status is false, then return error 500
	  if($response['status'] == false){
	  	return response()->json([
	       'result' => $response,
	     ], 500);
	  }
	  
	  // implement the final transfer
	  return $this->finalTransfer($response);
    }
    
    
    /*
    *	Final transfer after successfull transfer initiation
    */
    public function finalTransfer($response){
    
    	  $url = "https://api.paystack.co/transfer/finalize_transfer";
	  $fields = [
	    "transfer_code" => $response['data']['transfer_code'], // This is test, but can be generated on real account
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
