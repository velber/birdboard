<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 16/02/19
 * Time: 16:27
 */

namespace Tests\Setup;


use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $user;

    protected $tasksCount = 0;

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTasks(int $count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class),
        ]);

        if ($this->tasksCount) {
            factory(Task::class, $this->tasksCount)->create([
                'project_id' => $project->id,
            ]);
        }

        return $project;
    }

}