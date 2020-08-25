<?php

namespace App\Exceptions;

use App\Exceptions\OneException;

class UnauthorisedException extends OneException{

	protected $status = '401';


	public function __construct(){

		$message = $this->build(func_get_args());
		
		parent::__construct($message);
	}



}