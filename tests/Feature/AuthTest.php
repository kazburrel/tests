<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirect_to_dashbaord(): void
    {
        $user = User::factory()->create();
        User::create([
            'name' => 'obi',
            'email' => 'obi@gmail.com',
            'password' => bcrypt(value: 'password123')
        ]);
        $response = $this->post('/login', [
            'email' => 'obi@gmail.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(status: 302);
        $response->assertRedirect(uri: 'dashboard');
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(status: 302);
        $response->assertRedirect(uri: 'login');
    }
}
