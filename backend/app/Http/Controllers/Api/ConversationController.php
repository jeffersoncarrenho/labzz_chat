<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Http\Requests\StoreConversationRequest;

class ConversationController extends Controller
{
    public function store(StoreConversationRequest $request)
    {
        $conversation = Conversation::create([
            'type' => $request->type ?? 'private',
            'name' => $request->name
        ]);

        foreach ($request->participants as $userId) {

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $userId,
                'joined_at' => now()
            ]);
        }

        return response()->json($conversation);
    }

    public function index(StoreConversationRequest $request)
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
