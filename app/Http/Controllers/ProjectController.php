<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$user_id = $request->user()->id;
        //$projects = Project::where('creator_id', $user_id)->get();
        $projects = Project::all();
        foreach($projects as $project) {
            $project->creator_name = User::where('id', $project->creator_id)->first()->name;
        }
        //return $projects;
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
        ]);
        $name = $request->get('name');
        $user_id = $request->user()->id;
        $project = new Project([
            'name' => $name,
            'creator_id' => $user_id,
            'token' => Str::random(60),
        ]);
        $project->save();
        $sub = new Subscription();
        $sub->project_id = $project->id;
        $sub->user_id = $user_id;
        $sub->is_confirmed = true;
        $sub->save();

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //добавить вывод подписчиков на проект если creator_id = user_id
        //если это чужой проект добавить кнопку подписаться(запрос на подписку)

        $project->creator_name = User::where('id', $project->creator_id)->first()->name;
        $subscriptions = [];
        //return $project->creator_id . " " . Auth::id();
        if ($project->creator_id == Auth::id()) {
            $subscriptions = Subscription::where('project_id', $project->id)->get();
            foreach($subscriptions as $sub) {
                $user = User::where('id', $sub->user_id)->first();
                $sub->sub_name = $user->name;
            }
        }
        return view("projects.show", compact('project' , 'subscriptions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return redirect()->route('projects.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project) {
            $subs = Subscription::where('project_id', $project->id)->delete();
            $project->delete();
        }
        return redirect()->route("projects.index");
    }
}
