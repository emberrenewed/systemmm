<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Actions\LoginUserAction;
use Modules\Auth\Actions\LogoutUserAction;
use Modules\Auth\Actions\RegisterUserAction;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Resources\AuthResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action)
    {
        $result = $action->handle($request->validated());

        return AuthResource::make($result['user'])->additional([
            'message' => __('messages.register_success'),
            'token' => $result['token'],
        ])->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request, LoginUserAction $action)
    {
        $result = $action->handle($request->validated());

        if ($result['error']) {
            return response()->json(['message' => $result['message'],
                'errors' => ['email' => [$result['message']]], ], 422);
        }

        return AuthResource::make($result['user'])->additional([
            'message' => __('messages.login_success'),
            'token' => $result['token'],
        ]);
    }

    public function logout(Request $request, LogoutUserAction $action)
    {
        $action->handle($request->user());

        return response()->json([
            'message' => __('messages.logout_success'),
        ]);
    }
}
