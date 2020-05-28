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

    public function checkContributor($user_id, $project_id)
    {
        return Contributor::where('user_id', $user_id)->where('project_id', $project_id)->first();
    }

    public function storeContributor($project_id, array $usernames)
    {
        foreach ($usernames as $username)
        {
            $contributor = new Contributor;

            $user_id = User::where('username', $username)->pluck('id');
            $contributor->user_id = $user_id[0];
            $contributor->project_id = $project_id;

            if($contributor->save()) {
                //
            } else {
                return abort(404);
            };
        }
    }

    public function updateContributor($project_id, array $usernames)
    {
        $this->deleteContributorByProject($project_id);

        $this->storeContributor($project_id, $usernames);
    }

    public function deleteContributorByProject($project_id)
    {
        return Contributor::where('project_id', $project_id)->delete();
    }

}
