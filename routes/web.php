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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback')->name('facebook-callback');

Route::get('login/github', 'Auth\GithubController@redirectToProvider')->name('github-login');
Route::get('login/github/callback', 'Auth\GithubController@handleProviderCallback')->name('github-callback');

Route::get('send_test_email', function () {
    Mail::raw('Sending emails with Mailgun and Laravel is easy!', function ($message) {
        $message->to('giangnv@vnext.vn');
    });
});


Route::resource('categories', 'CategoryController');
