<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function handle($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
          
         return [
                'error' => true,
                'message' => 'The provided credentials are incorrect.',
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
