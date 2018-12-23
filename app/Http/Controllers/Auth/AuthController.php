<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;


class AuthController extends Controller
{

    protected function getResponse(Request $request){

        $user = User::where('email', $request->email)->get()->first();

        $token = $this->getToken($request->email, $request->password);

        $user->auth_token = $token;
        $user->save();


        return [
            'success' => true,
            'data' => $user
        ];


    }

    private function getToken($email, $password)
    {
        $token = null;

        try {


            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token' => $token
                ]);
            }

        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }

        if (!is_string($token)) {

            return response()->json(
                [
                    'success' => false,
                    'data' => 'Token generation failed'
                ], 201);

        }
        return $token;
    }


}