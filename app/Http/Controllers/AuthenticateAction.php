<?php

namespace App\Http\Controllers;

use App\Http\Actions\IAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AuthenticateAction implements IAction
{
    /**
     * JWT token generation action. This action has the only
     * purpose to generate a n authentication token based
     * on JWT, using the user password hash as a secret
     * for verifying the token validity.
     *
     * @param Request $request Request data
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function response(Request $request): JsonResponse
    {
        if (!$request->input('username')) {
            return response()->json('Unauthorized', 401);
        }

        $user = User::where('username', $request->input('username'))->first();
        if (!$user) {
            return response()->json('Unauthorized', 401);
        }

        if (Hash::check($request->input('password'), $user->hash)) {
            $encriptionSecret = app('hash')->make($request->input('password'));
            $now = (new DateTime())->getTimestamp();
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
                "publicKey" =>  Str::random()
            ];
            $data       = $this->base64url_encode(
                json_encode($jwtHeader)
            ).".".$this->base64url_encode(
                json_encode($jwtClaims)
            );
            $hashedData = HASH_HMAC("sha256", $data, $encriptionSecret);
            $signature  = $this->base64url_encode($hashedData);
            return response()->json(['token' => "$data.$signature"]);
        } else {
            return response()->json('Unauthorized', 401);
        }
    }

    // Helper private functions
    // ------------------------------------------------------------------------------------------------------
    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
      
    private function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen($data)) % 4));
    }
}
