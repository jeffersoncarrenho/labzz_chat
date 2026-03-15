<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;

class ListMessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_messages()
    {
        $user = User::factory()->create();

        $conversation = Conversation::create([
            'type' => 'private'
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'content' => 'hello',
            'status' => 'sent'
        ]);

        $response = $this->getJson("/api/v1/conversations/{$conversation->id}/messages");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'content' => 'hello'
            ]);
    }
}
