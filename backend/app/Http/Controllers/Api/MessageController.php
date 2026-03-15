<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Services\MessageService;
use App\Events\UserTyping;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(StoreMessageRequest $request)
    {
        $message = $this->messageService
            ->createMessage($request->validated());

        return response()->json($message);
    }

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
