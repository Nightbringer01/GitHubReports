<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Repo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Github\Client as GHClient;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;

class repoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('repo.index')->with(['repos' => Auth()->user()->repos, 'organizations' => Auth()->user()->organizations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $githubclient = new GHClient();
        $githubclient->authenticate(Auth()->user()->accesstoken, GHClient::AUTH_ACCESS_TOKEN);

        foreach ($githubclient->user()->orgs() as $org) {
            $locorg = array(
                "name" => $org['login'],
                "user_id" => Auth()->user()->id
            );
            Organization::firstOrCreate($locorg);
        }
        foreach ($githubclient->user()->myRepositories() as $Gitrepo) {
            $locrepo = array(
                "name" => $Gitrepo['full_name'],
                "user_id" => Auth()->user()->id
            );
            Repo::firstOrCreate($locrepo);
        }

        return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\View\View
     */
    public function show(Repo $repo)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\View\View
     */
    public function edit(Repo $repo)
    {
        return view('repo.edit', ['repo' => $repo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repo $repo)
    {

        $validatedData = $request->validate([
            'message' => 'max:255',
            'default_issue_label' => 'max:255',
            'post_report_message' => 'max:255',
        ]);

        // return $request;
        $repo->message = $request->message;
        $repo->default_issue_label = $request->default_issue_label;
        $repo->post_report_message = $request->post_report_message;
        $repo->save();
        return Redirect::to('repo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repo $repo)
    {
    }

    /**
     * Enable/Disable the specified resource in storage.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(Repo $repo)
    {
        $repo->active = !$repo->active;
        $repo->save();
        return redirect('repo');
    }

    /**
     * Show the specified resource in storage.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function issues(Repo $repo)
    {
        return view('repo.issue.index', ['issues' => $repo->issues(), 'repo' => $repo]);
    }

    /**
     * Show the specified resource in storage.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function issuecreate(Repo $repo)
    {
        return view('repo.issue.create', ['repo' => $repo]);
    }

    /**
     * store the specified resource in Github.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function issuestore(Request $request, Repo $repo)
    {
        $request->validate(
            [
                "name" => "max:50",
                "email" => "max:100",
                "title" => "required|max:50",
                "details" => "required|max:255",
            ]
        );

        $ghclient = new GHClient();
        $ghclient->authenticate($repo->user->accesstoken, GHClient::AUTH_ACCESS_TOKEN);

        $title = $request->title;
        $body = "Name: " . $request->name . "\r";
        $body .= "Email: " . $request->email . "\r";
        $body .= "\r\r";
        $body .= $request->details;

        $explodedname = explode('/', $repo->name);

        // return $explodedname;

        $ghclient->issue()->create($explodedname[0], $explodedname[1], array('title' => $title , 'body' => $body));
        return redirect()->route('repo.issues', ['repo' => $repo->id]);
    }
}
