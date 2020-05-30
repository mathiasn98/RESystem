<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessGoal extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'business_goals', 'project_id'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
