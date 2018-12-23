<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginEmailRequest;
use App\Models\User;
use JWTAuth;
use JWTAuthException;

class LoginController extends AuthController
{

    public function login(LoginEmailRequest $request)
    {
        $user = User::where('email', $request->email)->get()->first();


        if ($user && \Hash::check($request->password, $user->password)) // The passwords match...
        {
            $response = $this->getResponse($request);

        } else {

            $response = ['success' => false];

        }


        return response()->json($response, 201);
    }


}