<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_add_tasks_to_projects()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();
        $task = str_random(10);
        $this->post($project->path() . '/tasks', ['body' => $task])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => $task]);
    }
    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();
        $task = $project->addTask(str_random(10));
        $this->patch($task->path(), ['body' => 'sss'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'sss']);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $this->post($project->path() . '/tasks', ['body' => 'Lorem task']);
        $this->get($project->path())
            ->assertSee('Lorem task');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory(Task::class)->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('test t');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'new body',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'new body',
            'completed' => true,
        ]);
    }
}
