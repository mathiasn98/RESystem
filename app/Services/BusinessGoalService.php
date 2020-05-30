<?php

namespace App\Services;


use App\BusinessGoal;

class BusinessGoalService
{
    public function getBusinessGoalsByProject($project_id)
    {
        return BusinessGoal::where('project_id', $project_id)->pluck('business_goals')->toArray();
    }

    public function storeBusinessGoals($projectId, array $businessGoals)
    {
        foreach ($businessGoals as $businessGoalField)
        {
            $businessGoal = new BusinessGoal();

            $businessGoal->business_goals = $businessGoalField;
            $businessGoal->project_id = $projectId;

            if ($businessGoal->save())
            {

            } else {
                return abort(404);
            }
        }
    }

    public function updateBusinessGoals($project_id, array $businessGoals)
    {
        $this->deleteContributorByProject($project_id);

        $this->storeBusinessGoals($project_id, $businessGoals);
    }

    public function deleteContributorByProject($projectId)
    {
        return BusinessGoal::where('project_id', $projectId)->delete();
    }

}
