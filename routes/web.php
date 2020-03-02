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
/*
Route::get('/', function () {
    return view('welcome');
});**/

Auth::routes();


//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home/', function () {
    if (Auth::check()) {
        return view('admin');
    }
    return redirect('/login');

});

Route::get('/users', 'UsersController@index')->middleware('auth');
Route::post('/users', 'UsersController@create')->middleware('auth');

Route::resource('countries', 'CountriesController')->middleware('auth');

Route::resource('leagues', 'LeaguesController')->middleware('auth');

Route::resource('teams', 'TeamsController')->middleware('auth');

Route::resource('matchweeks', 'MatchweeksController')->middleware('auth');

Route::post('/participants/{uuid}', 'ParticipantsController@store')->middleware('auth');
Route::put('/participants', 'ParticipantsController@update')->middleware('auth');
Route::get('/participants/{$uuid}', 'ParticipantsController@find')->middleware('auth');
Route::delete('/participants', 'ParticipantsController@delete')->middleware('auth');


