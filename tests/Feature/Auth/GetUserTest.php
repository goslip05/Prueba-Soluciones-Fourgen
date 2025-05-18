<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;



    public function test_authenticated_user_can_access_profile()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'email']);
    }
}
