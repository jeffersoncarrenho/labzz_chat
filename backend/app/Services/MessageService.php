<?php

namespace App\Services;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Cache;

class MessageService
{
   public function createMessage(array $data)
    {
        $message = Message::create([
            'conversation_id' => $data['conversation_id'],
            'user_id' => $data['user_id'],
            'content' => $data['content'],
            'status' => 'sent'
        ]);
        Cache::forget("conversation_{$data['conversation_id']}_messages");

        event(new MessageSent($message));


        return $message;
    }
}
