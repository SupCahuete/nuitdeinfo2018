<?php

namespace App\Http\Controllers\Frontuser;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
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
  protected $redirectTo;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('frontuser.guest', ['except' => 'logout']);

    $this->redirectTo = route('frontuser.home.index');
  }

  /**
   * Show the application's login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('frontuser.login.index');
  }

  /**
   * Log the user out of the application.
   *
   * @return \Illuminate\Http\Response
   */
  public function logout()
  {
    $this->guard()->logout();
    session()->flush();
    session()->regenerate();

    return redirect()->route('frontuser.welcome.index');
  }

  /**
   * Attempt to get the guard from the local cache.
   *
   * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard() {
    return \Auth::guard($this->guard);
  }
}
