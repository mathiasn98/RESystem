<?php

namespace App\Services;

use App\Requirement;
use Illuminate\Support\Facades\Log;

class RequirementService
{
    public function getRequirementsByProject($project_id)
    {
        return Requirement::where('project_id', $project_id)->get();
    }

    public function storeRequirements($projectId, array $functional_req, array $non_functional_req)
    {
        Log::debug($non_functional_req);
        foreach ($functional_req as $requirementField)
        {
            $requirement = new Requirement();

            $requirement->type = 'Functional';
            $requirement->requirement = $requirementField;
            $requirement->project_id = $projectId;

            if ($requirement->save())
            {

            } else {
                return abort(404);
            }
        }

        foreach ($non_functional_req as $requirementField)
        {
            $requirement = new Requirement();

            $requirement->type = 'Non-Functional';
            $requirement->requirement = $requirementField;
            $requirement->project_id = $projectId;

            if ($requirement->save())
            {

            } else {
                return abort(404);
            }
        }
    }

    public function updateRequirements($project_id, array $functional_req, array $non_functional_req)
    {
        $this->deleteRequirementByProject($project_id);

        $this->storeRequirements($project_id, $functional_req, $non_functional_req);
    }

    public function deleteRequirementByProject($projectId)
    {
        return Requirement::where('project_id', $projectId)->delete();
    }

}
