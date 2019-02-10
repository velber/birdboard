<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return sprintf("/projects/%d/tasks/%d", $this->project->id, $this->id);
    }
}
