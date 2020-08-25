<?php

namespace App\Services;

use App\Exceptions\UnauthorisedException;
use Illuminate\Support\Facades\Auth;
use App\Helpers\JwtHelper;



class LoginUser
{
    public function __construct(){

    }

    public function execute(array $data){
       if(!$token = auth('api')->attempt($data)) {
            throw new UnauthorisedException('unauthorized', $data['email']);

          }
        return JwtHelper::respondWithToken($token);


    }

}
