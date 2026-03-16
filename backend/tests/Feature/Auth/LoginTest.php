<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
#use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\RefreshDatabaseWithoutPassport;

class LoginTest extends TestCase
{
    use RefreshDatabaseWithoutPassport;

    public function test_user_can_login_and_receive_login_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'login_token'
                 ]);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }
}
