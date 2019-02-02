<?php

namespace Tests\Feature;

use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     * @return void
     */
    public function a_user_can_create_a_project()
    {
        $this->withExceptionHandling();

        $project = factory(Project::class)->raw();

        $this->post('/projects', $project)
            ->assertRedirect('projects');
        $this->assertDatabaseHas('projects', $project);

        $this->get('/projects')->assertSee($project['title']);
    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
        $project = factory(Project::class)->raw(['title' => '']);
        $this->post('/projects', $project)
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_description_is_required()
    {
        $project = factory(Project::class)->raw(['description' => '']);
        $this->post('/projects', $project)
            ->assertSessionHasErrors('description');
    }

    /**
     * @test
     */
    public function a_user_can_view_a_project()
    {
        $this->withExceptionHandling();

        $project = factory(Project::class)->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}
