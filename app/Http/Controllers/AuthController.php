<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DateTime;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check the user credentials and generates JWT token
     */
    public function authentication(Request $request) {
        if (!$request->input('username')) {
            return response()->json('Unauthorized', 401);
        }

        $user = User::where('username', $request->input('username'))->first();
        if (!$user) {
            return response()->json('Unauthorized', 401);
        }

        if(Hash::check($request->input('password'), $user->hash)){
            $now = (new DateTime())->getTimestamp();
            $expirationTime = 
            $jwtHeader = [
                "iat"   =>  $now,
                "nbf"   =>  $now,
                "exp"   =>  23,
                "typ"   =>  "JWT",
                "alg"   =>  "HS256"
            ];
            $jwtClaims = [
                "userId"    =>  $user->id,
                "username"  =>  $user->username,
                "expiration"=>  (new DateTime())->getTimestamp()+(5*24*3600),
                "secret"    =>  env('APP_KEY')
            ];
            $data = $this->base64url_encode(json_encode($jwtHeader)).".".$this->base64url_encode(json_encode($jwtClaims));
            $hashedData = HASH_HMAC("sha256", $data, env('APP_KEY'));
            $signature = $this->base64url_encode($hashedData);
            return response()->json(['token' => "$data.$signature"]);
        } else {
            return response()->json('Unauthorized', 401);
        }
    }

    // Helper private functions
    private function base64url_encode( $data ){
        return rtrim( strtr( base64_encode( $data ), '+/', '-_'), '=');
    }
      
    private function base64url_decode( $data ){
        return base64_decode( strtr( $data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $data )) % 4 ));
    }
}