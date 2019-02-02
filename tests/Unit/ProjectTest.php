<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_has_a_path()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals(route('projects.show', [ 'project' => $project->id ]), $project->path());
    }
}
