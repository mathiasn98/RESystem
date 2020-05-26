<?php

namespace App\Services;

use App\Contributor;
use App\User;

class ContributorService
{
    public function getProjectIds($user_id)
    {
        return Contributor::where('user_id', $user_id)->pluck('project_id')->toArray();
    }

    public function getUser($project_id)
    {
        $user_ids = Contributor::where('project_id', $project_id)->pluck('user_id')->toArray();

        return User::whereIn('id', $user_ids)->get();
    }

}
