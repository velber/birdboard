<?php

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
});

Route::middleware('auth')->group(function () {

    // projects
    Route::resource('projects', 'ProjectsController');

    // project tasks
    Route::post('projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('tasks/{task}', 'ProjectTasksController@update');

    // project invitations
    Route::post('projects/{project}/invitations', 'ProjectInvitationsController@store');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
