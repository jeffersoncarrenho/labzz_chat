<?php

namespace Tests\Feature;

use Tests\TestCase;
#use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\RefreshDatabaseWithoutPassport;
use App\Models\User;
use App\Models\Conversation;
use Laravel\Passport\Passport;

class ListMessagesTest extends TestCase
{
    use RefreshDatabaseWithoutPassport;

    public function test_user_can_list_messages()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        Conversation::factory()->create();

        $response = $this->getJson('/api/v1/conversations');

        $response->assertStatus(200);
    }
}
