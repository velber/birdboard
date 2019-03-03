<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    public function path()
    {
        return route('projects.show', ['project' => $this->id]);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask(string $body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

    /**
     * @param string $type
     */
    public function createActivity(string $type): void
    {
        Activity::create([
            'project_id' => $this->id,
            'description' => $type,
        ]);
    }
}
