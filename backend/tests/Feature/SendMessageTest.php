<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Conversation;

class SendMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_message()
    {
        $user = User::factory()->create();

        $conversation = Conversation::create([
            'type' => 'private'
        ]);

        $response = $this->postJson('/api/v1/messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'content' => 'test message'
        ]);

        $response->assertStatus(200);
    }
}
