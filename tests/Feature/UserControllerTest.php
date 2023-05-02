<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
 
class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase, WithFaker;

    public function test_users_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'is_admin'=>false,
        ];

        $response = $this->post('users', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $data);
    }
    public function test_users_can_be_updated()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];

        $response = $this->put('/users/' . $user->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_users_can_be_deleted()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->delete('/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        
    }
}
