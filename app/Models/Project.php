<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $old = [];

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
        return $this->hasMany(Activity::class)->latest();
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
     * @param string $description
     */
    public function createActivity(string $description): void
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description),
        ]);
    }

    protected function activityChanges(string $description)
    {
        if ('updated' == $description) {
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at'),
            ];
        }
    }
}
