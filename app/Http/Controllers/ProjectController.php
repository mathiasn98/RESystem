<?php

namespace App\Http\Controllers;

use App\Project;
use App\Services\ContributorService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected $contributorService;

    public function __construct(ContributorService $contributorService)
    {
        $this->contributorService = $contributorService;
    }
//'last_process' => $faker->randomElement(['BUSINESS_GOALS', 'CBP', 'FIND_PATTERN', 'FBP', 'REQ_DEF', 'ACCEPTANCE'])

    private function getLastProcess($last_process)
    {
        switch ($last_process){
            case "BUSINESS_GOALS":
                return 'Business Goals';
            case "CBP":
                return 'Current Business Process';
            case "FIND_PATTERN":
                return 'Find Pattern';
            case "FBP":
                return 'Future Business Process';
            case "REQ_DEF":
                return 'Requirements Definition';
            case "ACCEPTANCE":
                return 'Acceptance';
            case "COMPLETED":
                return 'Completed';
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

            return redirect()->route('project.show', [$project->id]);
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
                'last_process' => $last_process
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
}
