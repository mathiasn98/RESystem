<?php

namespace App\Services;


use App\BusinessProcess;

class BusinessProcessService
{

    private $initBusinessProcess = '<?xml version="1.0" encoding="UTF-8"?>
        <definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" targetNamespace="" xsi:schemaLocation="http://www.omg.org/spec/BPMN/20100524/MODEL http://www.omg.org/spec/BPMN/2.0/20100501/BPMN20.xsd">
          <process id="Process_040c6r6" />
          <bpmndi:BPMNDiagram id="sid-74620812-92c4-44e5-949c-aa47393d3830">
            <bpmndi:BPMNPlane id="sid-cdcae759-2af7-4a6d-bd02-53f3352a731d" bpmnElement="Process_040c6r6" stroke="#000" fill="#fff" />
            <bpmndi:BPMNLabelStyle id="sid-e0502d32-f8d1-41cf-9c4a-cbb49fecf581">
              <omgdc:Font name="Arial" size="11" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" />
            </bpmndi:BPMNLabelStyle>
            <bpmndi:BPMNLabelStyle id="sid-84cb49fd-2f7c-44fb-8950-83c3fa153d3b">
              <omgdc:Font name="Arial" size="12" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" />
            </bpmndi:BPMNLabelStyle>
          </bpmndi:BPMNDiagram>
        </definitions>';

    public function getBusinessProcessByProjectAndType($project_id, $type)
    {
        $businessProcess = BusinessProcess::where([
            ['project_id', $project_id],
            ['type', $type]
        ])->get();

        if (count($businessProcess) == 0) {
            $businessProcess = array();
            $tempBusinessProcess = new BusinessProcess();
            $tempBusinessProcess->bpmn = $this->initBusinessProcess;
            $tempBusinessProcess->project_id = $project_id;
            $tempBusinessProcess->type = $type;
            array_push($businessProcess, $tempBusinessProcess);
        }
        return $businessProcess;
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
