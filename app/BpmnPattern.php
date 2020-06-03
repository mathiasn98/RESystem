<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpmnPattern extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'bpmn', 'title', 'category', 'description'
    ];
}
