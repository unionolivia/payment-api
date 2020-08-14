<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    /*
    *	Initial transfer money to a recepient
    */
    public function initiatingTransfer(){
    
	  $url = "https://api.paystack.co/transfer";
	  $fields = [
	    "source" => "balance", 
	    "reason" => "Calm down", 
	    "amount" => 3794800, 
	    "recipient" => "RCP_gx2wn530m0i3w3m"
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
	  return $this->finalTransfer();
  
    }
    
    /*
    *	Final transfer after successfull transfer initiation
    */
    public function finalTransfer(){
    
    	  $url = "https://api.paystack.co/transfer/finalize_transfer";
	  $fields = [
	    "transfer_code" => "TRF_vsyqdmlzble3uii", 
	    "otp" => "928783"
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
    
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
