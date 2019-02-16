<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_cannot_control_a_project()
    {
        $project = factory(Project::class)->create();
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_create_a_project()
    {
        $owner = factory(User::class)->create();
        $this->signIn($owner);
        $this->get('/projects/create')->assertStatus(200);

        $project = factory(Project::class)->raw(['owner_id'=> $owner->id]);

        $response = $this->post('/projects', $project);

        $projectModel = Project::where($project)->first();
        $response->assertRedirect($projectModel->path());

        $this->get($projectModel->path())
            ->assertSee($project['notes'])
            ->assertSee($project['title']);
    }
    /**
     * @test
     * @return void
     */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => str_random(10),])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
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
    public function a_user_can_view_his_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $owner = factory(User::class)->create();
        $this->be($owner);

        $project = factory(Project::class)->create();

        $this->get($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->patch($project->path())
            ->assertStatus(403);
    }
}
