<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public array $user = [
        'email' => 'bailor97@example.org',
        'password' => 'password',
        'name' => 'John Bailor',
        'remember_token' => 'djhYGk23',
        'email_verified_at' => '2022-09-12 12:53:07',
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_new_user(): void
    {
        $response = $this->postJson('/api/register', [
            ...$this->user,
            'password_confirmation' => $this->user['password']
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.user.name', $this->user['name']);
    }

    public function test_login_user(): void
    {
        User::factory()->create($this->user);

        $response = $this->postJson('/api/login', [
            'email' => $this->user['email'],
            'password' => $this->user['password'],
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('data.token', 'string'));
    }

    public function test_logout_user(): void
    {
        $response = $this
                ->actingAs(User::factory()->create($this->user), 'web')
                ->postJson('/api/logout');

        $response->assertStatus(200);
    }
}
