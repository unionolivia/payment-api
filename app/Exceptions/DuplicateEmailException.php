<?php

namespace App\Exceptions;

use App\Exceptions\OneException;

class DuplicateEmailException extends OneException{

	protected $status = '500';


	public function __construct(){

		$message = $this->build(func_get_args());
		
		parent::__construct($message);
	}



}