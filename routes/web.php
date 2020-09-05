<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('auth/githubcallback', 'Auth\LoginController@handleGithubCallback');

Route::get('auth/github', 'Auth\LoginController@redirectToGithub');

Route::get('repo/loadrepos', 'RepoController@create')->name('loadrepos')->middleware('auth');
Route::get('repo/{repo}/toggle', 'RepoController@toggleActive')->name('repo.toggleActive')->middleware('auth');

Route::get('repo/{repo}/issues', 'RepoController@issues')->name('repo.issues')->middleware('CheckRepoIsActive');
Route::get('repo/{repo}/issue/create', 'RepoController@issuecreate')->name('repo.issue.create')->middleware('CheckRepoIsActive');

Route::post('repo/{repo}/issue/store', 'RepoController@issuestore')->name('repo.issue.store')->middleware('CheckRepoIsActive');
Route::get('repo/{repo}/issue/store', 'RepoController@issues')->name('repo.issue.store')->middleware('CheckRepoIsActive');

Route::resource('repo', 'RepoController', ['except' => ['store', 'show']])->middleware('auth');

Auth::routes();
