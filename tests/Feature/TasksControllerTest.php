<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase; 
use App\Models\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
 
class TasksControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     
     use DatabaseTransactions;

      /** @test */
      public function it_can_create_a_task()
      {
          $taskData = [
              'assigned_by_id' => 1002,
              'title' => 'Test Task',
              'description' => 'This is a test task',
              'assign_to_id' => 6,
          ];
  
          $task = Task::create($taskData);
  
          $this->assertInstanceOf(Task::class, $task);
          $this->assertDatabaseHas('tasks', $taskData);
      }
}
