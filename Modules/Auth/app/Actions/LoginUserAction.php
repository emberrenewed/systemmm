<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;

class LoginUserAction
{
    public function handle($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {

            return [
                'error' => true,
                'message' => 'Check your email and password to correct.',
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'error' => false,
            'user' => $user,
            'token' => $token,
        ];
    }
}
