<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => $request->user_id,
            'content' => $request->content
        ]);

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
}
