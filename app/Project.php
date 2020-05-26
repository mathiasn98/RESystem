<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = true;

    protected $fillable = [
      'name', 'description', 'created_by', 'updated_by', 'last_process'
    ];

    public function contributor()
    {
        return $this->hasMany('App\Contributor', 'project_id');
    }
}
