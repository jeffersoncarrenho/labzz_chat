<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        $loginToken = Str::uuid()->toString();

        Redis::setex(
            "login_2fa:$loginToken",
            120,
            $user->id
        );

        return response()->json([
            'login_token' => $loginToken
        ]);
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'login_token' => 'required',
            'code' => 'required'
        ]);

        $userId = Redis::get("login_2fa:{$request->login_token}");

        if (!$userId) {
            return response()->json([
                'message' => 'Invalid or expired login token'
            ], 401);
        }

        $user = User::find($userId);

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $user->two_factor_secret,
            $request->code
        );

        if (!$valid) {
            return response()->json([
                'message' => 'Invalid 2FA code'
            ], 401);
        }

        Redis::del("login_2fa:{$request->login_token}");

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
