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
            $task->createActivity('created_task');
        });

        static::deleted(function ($task) {
            $task->createActivity('deleted_task');
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

        $this->createActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->createActivity('incompleted_task');
    }


    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @param string $description
     */
    public function createActivity(string $description): void
    {
        $this->activity()->create([
            'description' => $description,
            'project_id' => $this->project_id,
        ]);
    }
}
