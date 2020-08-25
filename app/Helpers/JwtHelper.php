<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class JwtHelper
{
   /**
   *	Generates a token for the logged in users
   */
   public static function respondWithToken($token) {
    return response()->json([
       'access_token' => $token,
       'token_type' => 'Bearer',
       'expires_in' => auth('api')->factory()->getTTL() * 60
     ]);
  }

   /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
   */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

  
     
}
