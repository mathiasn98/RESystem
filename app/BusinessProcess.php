<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessProcess extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'project_id', 'bpmn', 'type'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
