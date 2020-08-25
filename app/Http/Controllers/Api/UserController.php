<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CreateUser;
use App\Services\LoginUser;
use App\Services\CurrentUser;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    
    /*
    *	Register a User
    */
    public function register(CreateUserRequest $request, CreateUser $action){         
      $user = $action->execute($request->validated());
      return $user;
    }
        
    /**
    * Retrieves an Authenticated user
    */
    public function getAuthUser(CurrentUser $action) {
      return $action->execute();	
    }
      
    /**
    * Login a User
    */ 
    public function login(Request $request,  LoginUser $action) {
      $user = $action->execute(request(['email', 'password']));        
      return $user;
    }
        
    /**
     *	Logout a user
    */
    public function logout() {
      auth()->logout();
      return response()->json(['message' => 'Successfully logged out']);
    }
}
