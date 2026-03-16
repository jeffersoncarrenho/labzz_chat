<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Labzz Chat API",
    version: "1.0.0",
    description: "Realtime chat API built with Laravel"
)]

#[OA\Server(
    url: "http://localhost:8000/api/v1",
    description: "Local API server"
)]

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]

class OpenApi {}
