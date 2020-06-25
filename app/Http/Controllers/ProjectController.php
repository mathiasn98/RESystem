<?php

namespace App\Http\Controllers;

use App\BpmnPattern;
use App\Project;
use App\Services\BusinessGoalService;
use App\Services\BusinessProcessService;
use App\Services\ContributorService;
use App\Services\ProjectService;
use App\Services\RequirementService;
use App\User;
//use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $contributorService;
    protected $businessGoalService;
    protected $requirementService;
    protected $projectService;
    protected $businessProcessService;

    public function __construct(ContributorService $contributorService, BusinessGoalService $businessGoalService, RequirementService $requirementService, ProjectService $projectService, BusinessProcessService $businessProcessService)
    {
        $this->contributorService = $contributorService;
        $this->businessGoalService = $businessGoalService;
        $this->requirementService = $requirementService;
        $this->projectService = $projectService;
        $this->businessProcessService = $businessProcessService;
    }
//'last_process' => $faker->randomElement(['BUSINESS_GOALS', 'CBP', 'FIND_PATTERN', 'FBP', 'REQ_DEF', 'ACCEPTANCE'])

    private function getLastProcess($last_process)
    {
        switch ($last_process){
            case "BUSINESS_GOALS":
                return 'Tujuan Bisnis Proyek';
            case "CBP":
                return 'Penggambaran Proses Bisnis Saat Ini';
            case "FIND_PATTERN":
                return 'Penggunaan Template';
            case "FBP":
                return 'Penggambaran Proses Bisnis Proyek';
            case "REQ_DEF":
                return 'Pendefinisian Kebutuhan';
            case "ACCEPTANCE":
                return 'Persetujuan Kebutuhan Proyek';
            case "COMPLETED":
                return 'Selesai';
            default:
                return 'UNKNOWN';
        }
    }

    private function convertLastProcesses($projects){
        foreach ($projects as $project) {
            $project->last_process = $this->getLastProcess($project->last_process);
        }
        return $projects;
    }

    private function getLastProcessIndex($last_process){
        switch ($last_process){
            case "BUSINESS_GOALS":
                return 0;
            case "CBP":
                return 1;
            case "FIND_PATTERN":
                return 2;
            case "FBP":
                return 3;
            case "REQ_DEF":
                return 4;
            case "ACCEPTANCE":
                return 5;
            case "COMPLETED":
                return 6;
            default:
                return 7;
        }
    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
    public function index()
    {
        $project_ids = $this->contributorService->getProjectIds(Auth::user()->id);
        $projects = Project::find($project_ids)->sortByDesc('updated_at');

        $this->convertLastProcesses($projects);

        return view('projects/index')->with([
            'projects' => $projects
        ]);
    }

    public function mainMenu($projectId)
    {
        $project = Project::findOrFail($projectId);
        $contributors = $this->contributorService->getUser($projectId);
        return view('projects/mainmenu')->with([
            'project' => $project,
            'contributors' => $contributors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all()->pluck('username')->toArray();

        return view('projects/create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project();

        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->created_by = Auth::user()->username;
        $project->updated_by = Auth::user()->username;
        $project->last_process = $request->input('last_process');

        if($project->save())
        {
            $this->contributorService->storeContributor($project->id, $request->input('contributor'));

            return redirect()->route('project.index')->with([
                'project' => $project->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = $this->contributorService->checkContributor(Auth::user()->id, $id);

        if($check) {
            $project = Project::findOrFail($id);

            $contributors = $this->contributorService->getUser($id);

            $last_process = $project->last_process;

//            $scenarios = $this->scenarioService->getScenario($id);

            return view('projects/show', [
                'project' => $project,
                'contributors' => $contributors,
                'last_process' => $last_process,
                'lastProcessIndex' => $this->getLastProcessIndex($project->last_process)
            ]);
        } else {
            return abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $check = $this->contributorService->checkContributor(Auth::user()->id, $id);

        if($check) {
            $project = Project::findOrFail($id);

            $contributors = $this->contributorService->getUser($id);

            $users = User::all()->pluck('username')->toArray();

            return view('projects/edit')->with('project', $project)->with('contributors', $contributors)->with('users', $users);
        } else {
            abort(403);
        }
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
        $check = $this->contributorService->checkContributor(Auth::user()->id, $id);

        if($check) {
            $project = Project::findOrFail($id);

            $project->name = $request->input('name');
            $project->description = $request->input('description');
            $project->updated_by = Auth::user()->username;

            if($project->save()) {
                $this->contributorService->updateContributor($project->id, $request->input('contributor'));

                return redirect()->route('project.show', [$project->id]);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = $this->contributorService->checkContributor(Auth::user()->id, $id);

        if($check) {
            $project = Project::findOrFail($id);

            $this->contributorService->deleteContributorByProject($id);
//            $this->scenarioService->deleteByProject($id);

            if($project->delete()) {
                return redirect()->route('project.index');
            }
        } else {
            return abort(403);
        }
    }

    public function businessGoals($project_id)
    {
        $project = Project::findOrFail($project_id);
        return view('projects/business_goals')->with('project', $project)->with('initBusinessGoals', $this->businessGoalService->getBusinessGoalsByProject($project->id));
    }

    public function requirementsDefintion($project_id)
    {
        $project = Project::findOrFail($project_id);
        $bpmn = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'FBP')[0]['bpmn'];
        $this->projectService->updateStatus($project_id, 'Aktif');
        return view('projects/requirements_definition')->with('project', $project)->with('initRequirements', $this->requirementService->getRequirementsByProject($project_id))->with('bpmn', $bpmn);
    }

    public function rejectRequirements(Request $request)
    {
        if ($this->projectService->updateStatus($request->project_id, $request->reject_from)){
            return redirect()->to('/project/'.$request->project_id);
        } else {
            return abort(404);
        }
    }

    public function resetRequirements(Request $request)
    {
        if ($this->projectService->updateLastProcess($request->project_id, $request->reset_from)){
            $this->projectService->updateStatus($request->project_id, 'Aktif');
            if ($request->reset_from == 'BUSINESS_GOALS'){
                return redirect()->to('/project/'.$request->project_id.'/business_goals');
            } else {
                return redirect()->to('/project/'.$request->project_id.'/requirements_definition');
            }
        } else {
            return abort(404);
        }
    }

    public function acceptRequirements(Request $request)
    {
        $this->projectService->updateStatus($request->project_id, 'Disetujui');
        if ($this->projectService->updateLastProcess($request->project_id, 'COMPLETED')){
            return redirect()->to('/project/'.$request->project_id);
        } else {
            return abort(404);
        }
    }

    public function getCurrentBusinessProcess($project_id){
        $project = Project::findOrFail($project_id);
        $bpmn = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'CBP')[0]['bpmn'];
        return view('projects/current_business_process')->with('project', $project)->with('bpmn', $bpmn);
    }

    public function getFutureBusinessProcess($project_id, $pattern_id = -1){
        $project = Project::findOrFail($project_id);
        if ($pattern_id == -1){
            $bpmn = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'FBP')[0]['bpmn'];
        } else {
            $bpmn = BpmnPattern::findOrFail($pattern_id)['bpmn'];
        }
        return view('projects/future_business_process')->with('project', $project)->with('bpmn', $bpmn);
    }

    public function duplicateBusinessProcess($project_id){
        $project = Project::findOrFail($project_id);
        $bpmn = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'CBP')[0]['bpmn'];
        return view('projects/duplicate_business_process')->with('project', $project)->with('bpmn', $bpmn);
    }

    public function findPattern($project_id){
        $patterns = BpmnPattern::select(['id', 'title', 'description', 'category'])->get();
        $project = Project::findOrFail($project_id);
        return view('projects/find_pattern')->with('project', $project)->with('patterns', $patterns);
    }

    public function saveBusinessProcess(Request $request)
    {
        if ($this->businessProcessService->updateBusinessProcess($request->project_id, $request->type, $request->bpmn)){
            $nextLastProcess = ($request->type == 'CBP' ? 'FIND_PATTERN' : 'REQ_DEF');
            $this->projectService->updateLastProcess($request->project_id, $nextLastProcess);
            $this->projectService->updateStatus($request->project_id, 'Aktif');
            return redirect()->to('/project/'.$request->project_id);
        } else {
            return abort(404);
        }
    }

    public function export($project_id)
    {
        $project = Project::findOrFail($project_id);
        $contributors = $this->contributorService->getUser($project_id);
        $business_goals = $this->businessGoalService->getBusinessGoalsByProject($project_id);
        $requirements = $this->requirementService->getRequirementsByProject($project_id);
        $bpmn_cbp = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'CBP');
        $bpmn_fbp = $this->businessProcessService->getBusinessProcessByProjectAndType($project_id, 'FBP');


        return view('projects/export')->with('project', $project)
            ->with('business_goals', $business_goals)
            ->with('contributors', $contributors)
            ->with('requirements', $requirements)
            ->with('bpmn_cbp', $bpmn_cbp)
            ->with('bpmn_fbp', $bpmn_fbp);
    }

    public function download(Request $request)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadHTML($request->html);
        return $pdf->stream();
    }

    public function usePattern(Request $request)
    {
        return redirect()->to('/project/'.$request->project_id.'/future_business_process/'.$request->pattern_id);
//        return $this->getFutureBusinessProcess($request->project_id, $request->pattern_id);
    }

    public function skipPattern(Request $request)
    {
        $this->projectService->updateLastProcess($request->project_id, 'FBP');
        return redirect()->to('/project/'.$request->project_id);
    }

    public function changeStatus(Request $request)
    {
        $this->projectService->updateStatus($request->project_id, 'Diajukan');
        return redirect()->to('/project/'.$request->project_id);
    }
}
