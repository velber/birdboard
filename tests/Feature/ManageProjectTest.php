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
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_create_a_project()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);

        $this->followingRedirects()
            ->post('/projects', $project = factory(Project::class)->raw())
            ->assertSee($project['notes'])
            ->assertSee($project['title']);
    }

    /** @test */
    public function task_can_be_included_as_part_of_roject()
    {
        $this->signIn();
        $attributes = factory(Project::class)->raw();
        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2'],
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    function a_user_can_see_projects_that_was_invited()
    {
        $user = $this->signIn();
        $project = tap(ProjectFactory::create())->invite($user);

        $this->get(route('projects.index'))->assertSee($project->title);
    }

    /** @test */
    function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));

    }

    /** @test */
    function unauthorized_users_can_not_delete_projects()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('projects', $project->only('id'));

        $project->invite($user);
        $this->actingAs($user)
            ->delete($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [
                'notes' => str_random(10),
                'title' => 'Changed',
                'description' => 'Changed',
                ])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);
    }

    /**
     * @test
     * @return void
     */
    public function a_user_can_update_a_project_general_otes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [
                'notes' => str_random(10),
                ])
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
