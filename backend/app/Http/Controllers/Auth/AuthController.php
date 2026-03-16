<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\TwoFactorService;
use OpenApi\Attributes as OA;

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

    #[OA\Post(
        path: "/auth/login",
        tags: ["Auth"],
        summary: "Login user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "user@email.com"),
                    new OA\Property(property: "password", type: "string", example: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login successful"
            ),
            new OA\Response(
                response: 401,
                description: "Invalid credentials"
            )
        ]
    )]
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

    #[OA\Post(
        path: "/auth/2fa/verify",
        tags: ["Auth"],
        summary: "Verify two factor authentication",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["login_token", "code"],
                properties: [
                    new OA\Property(property: "login_token", type: "string", example: "uuid-token"),
                    new OA\Property(property: "code", type: "string", example: "123456")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Authenticated")
        ]
    )]
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
