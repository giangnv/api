<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

class GithubController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $userSocial = Socialite::driver('github')->user();

        // dd($userSocial, $userSocial->user);
        
        $user = User::where('email', $userSocial['email'])->first();
        if ($user) {
            if (Auth::loginUsingId($user->id)) {
                return redirect()->route('home');
            }
        }

        // else sign up this user
        $userSignup = User::create([
            'name' => $userSocial->nickname,
            'email' => $userSocial->user['email'],
            'password' => bcrypt('1234'),
            'avatar' => $userSocial->avatar,
            'github_profile' => $userSocial->user['html_url'],
        ]);

        if ($userSignup) {
            if (Auth::loginUsingId($userSignup->id)) {
                return redirect()->route('home');
            }
        }
    }
}
