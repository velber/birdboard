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
}
