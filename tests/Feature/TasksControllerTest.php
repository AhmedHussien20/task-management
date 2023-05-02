<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task; 

class TasksControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     

    public function test_task_can_be_created()
    {
        $data = [
            'title' => 'Test task',
            'description' => 'This is a test task.',
            'assign_to_id'=> 4,
            'assigned_by_id'=>5,
        ];
        
        $response = $this->post('/tasks', $data);
        
        $response->assertStatus(302);
        $response->assertRedirect('/tasks'); // Update with the correct redirect path
        $this->assertDatabaseHas('tasks', $data);
    }
}
