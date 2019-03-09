<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    public function created(Project $project)
    {
        // moved to RecordActivity trait
//        $project->recordActivity('created');
    }


    public function updated(Project $project)
    {
//        $project->recordActivity('updated');
    }
}
