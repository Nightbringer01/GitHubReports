<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Repo;
use Github\Client as GHClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use SebastianBergmann\Environment\Console;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['repos'=> Auth()->user()->repos, 'organizations'=> Auth()->user()->organizations]);
    }

    public function LoadRepos()
    {
        $githubclient = new GHClient();
        $githubclient->authenticate(Auth()->user()->accesstoken, GHClient::AUTH_ACCESS_TOKEN);
        foreach($githubclient->user()->orgs() as $org){
            $locorg = array("name" => $org['login'], 
                            "user_id" => Auth()->user()->id);
            Organization::firstOrCreate($locorg);
        }
        foreach($githubclient->user()->myRepositories() as $Gitrepo){
            $locrepo = array("name" => $Gitrepo['full_name'], 
                            "user_id" => Auth()->user()->id);
            Repo::firstOrCreate($locrepo);
        }

        return Redirect::back();
    }
}
