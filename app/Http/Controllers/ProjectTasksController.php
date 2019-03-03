<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Task $task)
    {
        $this->authorize('update', $task->project);

        $task->update(request()->validate(['body' => 'required']));

        $method = request('completed') ? 'complete' : 'incomplete';

        $task->$method();

        return redirect($task->project->path());
    }
}
