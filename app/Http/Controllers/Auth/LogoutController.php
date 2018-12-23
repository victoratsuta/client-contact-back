<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTAuthException;

class LogoutController extends controller
{
    public function logout(){



        try{

            User::findOrFail(Auth::user()->id)->update(
                [
                    'auth_token' => null
                ]
            );

        }
        catch (\Exception $e){

            return response()->json(
                [
                    'success' => false,
                    'data' => $e->getMessage()
                ]
            );

        }

        return response()->json(
            [
                'success' => true,
                'data' => 'logout'
            ]
        );

    }

}