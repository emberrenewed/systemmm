<?php

namespace Modules\Auth\Actions;

class LogoutUserAction
{
    public function handle($user)
    {
        $user?->currentAccessToken()?->delete();
    }
}
