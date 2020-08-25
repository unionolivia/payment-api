<?php

namespace App\Services;


use Illuminate\Support\Facades\Auth;
use JWTAuth;


class CurrentUser
{
    public function __construct(){

    }

    public function execute(){
        
      $user = JWTAuth::parseToken()->authenticate();
      return $user;
        
    }



}
