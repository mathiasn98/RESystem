<?php

namespace App\Services;


use App\Project;

class ProjectService
{
    public function updateLastProcess($project_id, $last_process)
    {
        $affected = Project::where('id', $project_id)->update(['last_process' => $last_process]);
        return $affected;
    }

}
