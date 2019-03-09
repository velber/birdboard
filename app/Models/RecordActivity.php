<?php

namespace App\Models;


trait RecordActivity
{
    /**
     * The project's old attributes.
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait.
     */
    public static function bootRecordActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ('updated' === $event) {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * The activity feed for the project.
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * Record activity for the project.
     *
     * @param string $description
     */
    public function recordActivity(string $description): void
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    /**
     * Get the description of the activity.
     *
     * @param $description
     * @return string
     */
    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * Fetch the changes to the model.
     *
     * @return array
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    /**
     * Fetch the model events that should trigger activity.
     *
     * @return array
     */
    protected static function recordableEvents()
    {
        return isset(static::$recordableEvents) ? static::$recordableEvents : ['created', 'updated', 'deleted'];
    }
}