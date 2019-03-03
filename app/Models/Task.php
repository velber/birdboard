<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->project->createActivity('created_task');
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return sprintf("/tasks/%d", $this->id);
    }

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->project->createActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
    }
}
