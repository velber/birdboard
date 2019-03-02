<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{
    public function created(Project $project)
    {
        $this->createActivity($project, 'created');
    }

    public function updated(Project $project)
    {
        $this->createActivity($project, 'updated');
    }

    protected function createActivity(Project $project, string $type): void
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => $type,
        ]);
    }
}
