<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class AuthService
{
    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();

        $loginToken = Str::uuid()->toString();

        Cache::put("login_2fa:$loginToken", $user->id, 120);

        return $loginToken;
    }
}
