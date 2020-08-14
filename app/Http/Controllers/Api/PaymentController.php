<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\TransferPayment;
use App\Http\Traits\PaymentHistory;

class PaymentController extends Controller
{

    use TransferPayment, PaymentHistory;
    
    
    /*
    *	Initiate a transfer receipt to pay a customer
    */
    
    public function transferReceipt(Request $request)
    {
    	// Let's verify the account number
    	$account =  $this->verifyAccountNumber($request->account_number);
    	
    	$data = array('amount' => $request->amount,
    			'reason' => $request->reason
    		      );
    	
    	  if($account['status'] == false){
    	  return response()->json([
	       'result' => 'The account number is not entered correctly. Please try again.',
	     ], 500);
    	   }
    	  
    	  // Let's process the payment to get a recepient code for the transfer
    	  $receiptTransferResponse = $this->recepientTransfer($request->account_number);
    	  
	  $transferResponse = $this->initiatingTransfer($receiptTransferResponse, $data); //Let initiate the transfer
	  
	  return $transferResponse;
	}
	
	
	/*
	*  list and search through customer history
	*/
	
	public function customerHistory(){
	  
	  return $this->history();
	}
    
    
}
