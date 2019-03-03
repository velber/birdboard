<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = factory(Task::class)->create();
        $this->assertFalse($task->completed);

        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }
}
