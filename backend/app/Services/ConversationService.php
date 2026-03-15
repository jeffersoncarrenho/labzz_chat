<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\ConversationParticipant;

class ConversationService
{
    public function createConversation(array $data)
    {
        $conversation = Conversation::create([
            'type' => $data['type'],
            'name' => $data['name'] ?? null
        ]);

        foreach ($data['participants'] as $userId) {

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $userId,
                'joined_at' => now()
            ]);
        }

        return $conversation;
    }
}
