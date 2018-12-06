<?php

namespace TAG_NAMESPACE_NAME;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class TAG_CLASS_NAME extends Controller
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
    $this->middleware(AuthInterface::MIDDLEWARE_GUEST, ['except' => 'logout']);

    $this->redirectTo = route('TAG_GUARD_NAME.home.index');
  }

  /**
   * Show the application's login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('TAG_GUARD_NAME.login.index');
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

    return redirect()->route('TAG_GUARD_NAME.welcome.index');
  }

  /**
   * Attempt to get the guard from the local cache.
   *
   * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard() {
    return Auth::guard(AuthInterface::GUARD);
  }

}
