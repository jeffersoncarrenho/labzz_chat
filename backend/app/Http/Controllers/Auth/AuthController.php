<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\TwoFactorService;

class AuthController extends Controller
{
    protected AuthService $authService;
    protected TwoFactorService $twoFactorService;

    public function __construct(
        AuthService $authService,
        TwoFactorService $twoFactorService
    ) {
        $this->authService = $authService;
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Step 1 - Validate credentials and return temporary login token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $loginToken = $this->authService->login(
            $request->only('email', 'password')
        );

        if (!$loginToken) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'login_token' => $loginToken
        ]);
    }

    /**
     * Step 2 - Verify 2FA code and issue OAuth token
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'login_token' => 'required',
            'code' => 'required'
        ]);

        $result = $this->twoFactorService->verify(
            $request->login_token,
            $request->code
        );

        if ($result === null) {
            return response()->json([
                'message' => 'Invalid or expired login token'
            ], 401);
        }

        if ($result === false) {
            return response()->json([
                'message' => 'Invalid 2FA code'
            ], 401);
        }

        $user = $result;

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
