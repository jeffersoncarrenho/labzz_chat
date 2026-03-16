<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Http\Requests\StoreConversationRequest;
use App\Services\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function store(StoreConversationRequest $request)
    {
        $conversation = $this->conversationService
            ->createConversation($request->validated());

        return response()->json($conversation);
    }

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
