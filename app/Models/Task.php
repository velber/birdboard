<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivity;

    protected $guarded = ['id'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected static $recordableEvents = ['created', 'deleted'];

    protected static function boot()
    {
        parent::boot();
        // moved to RecordActivity trait
//        static::created(function ($task) {
//            $task->recordActivity('created_task');
//        });
//
//        static::deleted(function ($task) {
//            $task->recordActivity('deleted_task');
//        });
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

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('incompleted_task');
    }


    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
