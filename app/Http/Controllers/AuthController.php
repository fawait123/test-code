<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('username',$request->username)->first();

        if(!$user){
            return response()->json([
                'success'   => false,
                'message'   => 'The credentials doesnt match to our record',
                'data'      => []
            ],404);
        }

        if(!Hash::check($request->password,$user->password)){
            return response()->json([
                'success'   => false,
                'message'   => 'The credentials doesnt match to our record',
                'data'      => []
            ],404);
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'success'   => true,
            'message'   => 'Login successfuly',
            'data'      => [
                'token'=>$token,
                'user'=>$user
            ]
        ],200);




    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'fullname'=>$request->fullname
        ]);


        return response()->json([
            'success'   => true,
            'message'   => 'Register successfully',
            'data'      => $user
        ],201);
    }


    public function unauthorized()
    {
        return response()->json([
            'success'   => false,
            'message'   => 'Unauthorized',
            'data'      => []
        ],401);
    }
}
