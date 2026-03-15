<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function createMessage(array $data)
    {
        return Message::create([
            'conversation_id' => $data['conversation_id'],
            'user_id' => $data['user_id'],
            'content' => $data['content']
        ]);
    }
}
