<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    
    /*
    *	Register a User
    */
    public function register(Request $request)
        {
        try{
           $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
         // Immediately login the user
      	$token = auth()->login($user);   
      	}   	
      	catch(\Illuminate\Database\QueryException $e){
      		 return response()->json(['success' => 0,
                                   'message' => 'User already exist.Please try again'], 500);
      	}
      	return $this->respondWithToken($token);
        }
        
        /**
        * Retrieves an Authenticated user
        */
         public function getAuthUser(Request $request) {
    		try {
    			 if (!$user = JWTAuth::parseToken()->authenticate()) {
          			  return response()->json(['user_not_found'], 404);
           		}

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
   }
      
     /**
     * Login a User
     */ 
     public function login(Request $request) {
     $credentials = $request->only(['email', 'password']);

      if(!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorised'], 401);
      }
      
      return $this->respondWithToken($token);
   }
        
   /**
   *	Logout a user
   */
   public function logout() {
     auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);
   }
   
   
   
   /**
   *	Generates a token for the logged in users
   */
   protected function respondWithToken($token) {
    return response()->json([
       'access_token' => $token,
       'token_type' => 'Bearer',
       'expires_in' => auth('api')->factory()->getTTL() * 60
     ]);
  }
}
