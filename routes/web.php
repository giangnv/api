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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback')->name('facebook-callback');

Route::get('login/github', 'Auth\GithubController@redirectToProvider')->name('github-login');
Route::get('login/github/callback', 'Auth\GithubController@handleProviderCallback')->name('github-callback');

Route::get('send_test_email', function () {
    Mail::raw('Sending emails with Mailgun and Laravel is easy!', function ($message) {
        $message->to('giangnv@vnext.vn');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('nominations', 'NominationController');
    Route::resource('votings', 'VotingController');
});

Route::middleware(['admin', 'moderator'])->group(function () {
    Route::resource('nominationUsers', 'NominationUserController');
    
    // Users
    Route::get('users', 'UserController@index');
    Route::delete('users', 'UserController@destroy');
    Route::match(['put', 'patch'], 'users/{user}', 'UserController@update');

    // Categories
    Route::delete('categories', 'CategoryController@destroy');
    Route::match(['put', 'patch'], 'categories/{category}', 'CategoryController@update');
    Route::post('categories', 'CategoryController@store');
    Route::get('categories/create', 'CategoryController@create')->name('categories.create');

    // Nominations
    Route::delete('nominations', 'NominationController@destroy');
    Route::match(['put', 'patch'], 'nominations/{nomination}', 'NominationController@update');

    Route::resource('users', 'UserController');
    Route::middleware(['admin'])->group(function () {
        Route::resource('roles', 'RoleController');
        Route::resource('settings', 'SettingController');
    });
});

Route::resource('users', 'UserController');
