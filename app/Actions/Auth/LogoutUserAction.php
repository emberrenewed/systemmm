<?php

namespace App\Actions\Auth;

class LogoutUserAction
{
    public function handle($user)
    {
        $user?->currentAccessToken()?->delete();
    }
}
