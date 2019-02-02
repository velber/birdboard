<?php

namespace Tests\Feature;

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

        $project = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $this->post('/projects', $project);
        $this->assertDatabaseHas('projects', $project);

//        $this->get('/projects')->assertSee($project['title']);
    }
}
