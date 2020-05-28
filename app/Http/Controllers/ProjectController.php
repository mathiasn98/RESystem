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

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
    public function index()
    {
        $project_ids = $this->contributorService->getProjectIds(Auth::user()->id);
        $projects = Project::find($project_ids)->sortByDesc('updated_at');

        return view('projects/index')->with('projects', $projects);
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

            return redirect()->route('project.show', ['id' => $project->id]);
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
