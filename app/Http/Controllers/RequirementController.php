<?php

namespace App\Http\Controllers;

use App\Services\BusinessGoalService;
use App\Services\ProjectService;
use App\Services\RequirementService;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    protected $projectService;
    protected $requirementService;

    public function __construct(ProjectService $projectService, RequirementService $requirementService)
    {
        $this->projectService = $projectService;
        $this->requirementService = $requirementService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $functionalReq = $request->input('functional_req');
        $nonFunctionalReq = $request->input('non_functional_req');
        $projectId = $request->input('project_id');
        $this->requirementService->updateRequirements($projectId, $functionalReq, $nonFunctionalReq);
        $this->projectService->updateLastProcess($projectId, 'ACCEPTANCE');

        return redirect()->route('project.show', [$projectId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
