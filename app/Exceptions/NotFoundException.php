<?php

namespace App\Exceptions;

use App\Exceptions\OneException;

class NotFoundException extends OneException{

	protected $status = '404';


	public function __construct(){

		$message = $this->build(func_get_args());
		
		parent::__construct($message);
	}



}