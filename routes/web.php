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
Route::post('get-all-user', [
    'as' => 'get-all-user',
    'uses' => 'UserController@getAllUser'
]);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

