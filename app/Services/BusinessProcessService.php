<?php

namespace App\Services;


use App\BusinessProcess;

class BusinessProcessService
{
    public function getBusinessProcessByProjectAndType($project_id, $type)
    {
        return BusinessProcess::where([
            ['project_id', $project_id],
            ['type', $type]
        ])->get();
    }

    public function storeBusinessProcess($project_id, $type, $bpmn)
    {
        $businessProcess = new BusinessProcess();
        $businessProcess->project_id = $project_id;
        $businessProcess->type = $type;
        $businessProcess->bpmn = $bpmn;


        if($businessProcess->save()) {
            //
        } else {
            return abort(404);
        };
    }

    public function updateBusinessProcess($project_id, $type, $bpmn)
    {
        $this->deleteBusinessProcessByProjectAndType($project_id, $type);

        $this->storeBusinessProcess($project_id, $type, $bpmn);

        return true;
    }

    public function deleteBusinessProcessByProjectAndType($project_id, $type)
    {
        return BusinessProcess::where([
            ['project_id', $project_id],
            ['type', $type]
        ])->delete();
    }
}
