<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function only_auth_users_can_create_a_project()
    {
        $project = factory(Project::class)->raw();
        $this->post('/projects', $project)
            ->assertRedirect('login');
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_create_a_project()
    {
        $this->withExceptionHandling();
        $owner = factory(User::class)->create();
        $this->actingAs($owner);

        $project = factory(Project::class)->raw(['owner_id'=> $owner->id]);

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
        $this->actingAs(factory(User::class)->create());
        $project = factory(Project::class)->raw(['title' => '']);
        $this->post('/projects', $project)
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_description_is_required()
    {
        $this->actingAs(factory(User::class)->create());
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
