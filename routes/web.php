<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/project/{projectId}', 'ProjectController@mainMenu')->middleware('auth');
Auth::routes();

Route::resource('project', 'ProjectController')->middleware('auth');

Route::get('/project/{project_id}/business_goals', [
    'as' => 'project.business_goals',
    'uses' => 'ProjectController@businessGoals'
])->middleware('auth');

Route::get('/project/{project_id}/requirements_definition', [
    'as' => 'project.requirements_definition',
    'uses' => 'ProjectController@requirementsDefintion'
])->middleware('auth');

Route::get('/project/{project_id}/current_business_process', [
    'as' => 'project.current_business_process',
    'uses' => 'ProjectController@getCurrentBusinessProcess'
])->middleware('auth');

Route::resource('project.business_goal', 'BusinessGoalController')->middleware('auth');
Route::resource('project.requirements_definition', 'RequirementController')->middleware('auth');

Route::post('get-all-user', [
    'as' => 'get-all-user',
    'uses' => 'UserController@getAllUser'
]);

Route::post('/project/reject', [
    'as' => 'project.reject',
    'uses' => 'ProjectController@rejectRequirements'
])->middleware('auth');

Route::post('/project/accept', [
    'as' => 'project.accept',
    'uses' => 'ProjectController@acceptRequirements'
])->middleware('auth');

Route::post('/project/save_business_process', [
    'as' => 'project.save_business_process',
    'uses' => 'ProjectController@saveBusinessProcess'
])->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

