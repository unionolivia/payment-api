<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Exceptions\DuplicateEmailException;
use App\User;



class CreateUser
{
    public function __construct(){

    }

    public function execute(array $data) : User{
        $email = $data['email'];
        if(User::where('email', $email)->first()){
            throw new DuplicateEmailException('internal_server_error', $email);
        }

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        $user->save();

        return $user;


    }
}
