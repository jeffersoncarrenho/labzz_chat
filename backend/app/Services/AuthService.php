<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class AuthService
{
    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();

        $loginToken = Str::uuid()->toString();

        Redis::setex(
            "login_2fa:$loginToken",
            120,
            $user->id
        );

        return $loginToken;
    }
}
