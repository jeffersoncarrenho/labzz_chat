<?php

namespace App\Services;

use App\Models\Message;
use App\Events\MessageSent;

class MessageService
{
   public function createMessage(array $data)
    {
        $message = Message::create([
            'conversation_id' => $data['conversation_id'],
            'user_id' => $data['user_id'],
            'content' => $data['content']
        ]);

        event(new MessageSent($message));

        return $message;
    }
}
