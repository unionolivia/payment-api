<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransferHistory;
use App\Services\VerifyAccount;

class PaymentController extends Controller
{
	
	/*
    *	Initiate a transfer receipt to pay a customer
    */
	public function transferReceipt(Request $request, VerifyAccount $act){
		return $act->execute($request->all());
	}
    	
	/*
	*  list and search through customer history
	*/
	public function customerHistory(TransferHistory $act){
	  return $act->execute();
	}
    
    
}
