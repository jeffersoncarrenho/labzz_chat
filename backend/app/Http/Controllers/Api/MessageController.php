<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Services\MessageService;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
class MessageController extends Controller
{
    protected $messageService;
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }


    #[OA\Post(
        path: "/messages",
        tags: ["Messages"],
        summary: "Send message",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["conversation_id", "content"],
                properties: [
                    new OA\Property(property: "conversation_id", type: "integer", example: 1),
                    new OA\Property(property: "content", type: "string", example: "Hello world")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Message sent")
        ]
    )]
    public function store(StoreMessageRequest $request)
    {
        $message = $this->messageService
            ->createMessage($request->validated());

        return response()->json($message);
    }

    #[OA\Get(
        path: "/conversations/{id}/messages",
        tags: ["Messages"],
        summary: "List conversation messages",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Messages list")
        ]
    )]
    public function index($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->with('user')
            ->orderBy('id')
            ->paginate(20);

        return response()->json($messages);
    }
    public function typing(Request $request)
    {
        event(new UserTyping(
            $request->conversation_id,
            $request->user_id
        ));

        return response()->json([
            'status' => 'typing event sent'
        ]);
    }
}
