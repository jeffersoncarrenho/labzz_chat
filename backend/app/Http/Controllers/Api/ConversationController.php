<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Http\Requests\StoreConversationRequest;
use App\Services\ConversationService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    #[OA\Post(
        path: "/conversations",
        operationId: "createConversation",
        tags: ["Conversations"],
        summary: "Create conversation",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["type", "participants"],
                properties: [
                    new OA\Property(
                        property: "type",
                        type: "string",
                        example: "private"
                    ),
                    new OA\Property(
                        property: "participants",
                        type: "array",
                        items: new OA\Items(type: "integer"),
                        example: [1, 2]
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Conversation created",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "type", type: "string", example: "private"),
                        new OA\Property(property: "created_at", type: "string", example: "2026-03-16 10:00:00")
                    ]
                )
            )
        ]
    )]
    public function store(StoreConversationRequest $request)
    {
        $conversation = $this->conversationService
            ->createConversation($request->validated());

        return response()->json($conversation);
    }

    #[OA\Get(
        path: "/conversations",
        operationId: "listConversations",
        tags: ["Conversations"],
        summary: "List user conversations",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of conversations",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "type", type: "string", example: "private"),
                            new OA\Property(property: "created_at", type: "string", example: "2026-03-16 10:00:00")
                        ]
                    )
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $userId = $request->user_id;

        $conversations = Conversation::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with('participants')
        ->get();

        return response()->json($conversations);
    }
}
