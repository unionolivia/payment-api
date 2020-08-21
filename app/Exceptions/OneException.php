<?php

namespace App\Exceptions;

use Exception;

abstract class OneException extends Exception{

protected $id;

protected $status;

protected $title;

protected $detail;

public function __construct($message){
	parent::__construct($message);
}

/*
* Get the status
*/
public function getStatus(){
	return (int) $this->status;
}

/*
* Return the Exception as an array
*/
public function toArray(){
	return [
	 'id' => $this->id,
	 'status' => $this->status,
	 'title' => $this->title,
	 'detail' => $this->detail
	];
}

/*
* Build the Exception
* 
*/
protected function build(array $args){
	$this->id = array_shift($args);
	$error = config(sprintf('errors.%s', $this->id));

	$this->title = $error['title'];
	$this->detail = vsprintf($error['detail'], $args);

	return $this->detail;
}


}
