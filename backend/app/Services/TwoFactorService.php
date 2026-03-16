<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class TwoFactorService
{
    public function verify(string $loginToken, string $code)
    {
        $userId = Redis::get("login_2fa:$loginToken");

        if (!$userId) {
            return null;
        }

        $user = User::find($userId);

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $user->two_factor_secret,
            $code,
            1
        );

        if (!$valid) {
            return false;
        }

        Redis::del("login_2fa:$loginToken");

        return $user;
    }
}
