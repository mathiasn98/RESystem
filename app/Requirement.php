<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type', 'requirement', 'project_id'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
