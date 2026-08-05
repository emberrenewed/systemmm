<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;


class AuthController extends Controller
{

//register
    public function register(RegisterRequest $request, RegisterUserAction $action)
    
    {
        $result = $action->handle($request->validated());

        return AuthResource::make($result['user'])->additional([
                'message' => 'User registered successfully.',
                'token' => $result['token'],])->response()->setStatusCode(201);
    }

    //login
    public function login(LoginRequest $request, LoginUserAction $action)
    
    {
        $result = $action->handle($request->validated());

        if ($result['error']) 
            {
                return response()->json(['message' => $result['message'],
                'errors' => ['email' => [$result['message']],],], 422);
             }

            return AuthResource::make($result['user'])->additional([
                    'message' => 'Login successful.',
                    'token' => $result['token'],
                ]);
    }


    //logout
    public function logout(Request $request, LogoutUserAction $action)
    
    {
        $action->handle($request->user());

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
} 