<?php

namespace App\Http\Controllers;

use App\BusinessGoal;
use App\Services\BusinessGoalService;
use App\Services\ContributorService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class BusinessGoalController extends Controller
{
    protected $businessGoalService;
    protected $projectService;

    public function __construct(BusinessGoalService $businessGoalService, ProjectService $projectService)
    {
        $this->businessGoalService = $businessGoalService;
        $this->projectService = $projectService;
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
//        $businessGoals = BusinessGoal::
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $businessGoals = $request->input('business_goals');
        $projectId = $request->input('project_id');
        $this->businessGoalService->updateBusinessGoals($projectId, $businessGoals);
        $this->projectService->updateLastProcess($projectId, 'CBP');

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
