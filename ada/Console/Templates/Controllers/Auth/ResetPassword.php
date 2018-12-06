<?php

namespace TAG_NAMESPACE_NAME;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TAG_CLASS_NAME extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo;

  /**
   * Path's password reset view.
   *
   * @var string
   */
  protected $passwordResetView;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(AuthInterface::MIDDLEWARE_GUEST);
  }


  /**
   * Display the password reset view for the given token.
   *
   * If no token is present, display the link request form.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string|null  $token
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index(Request $request, $token = null)
  {
    return view('TAG_GUARD_NAME.resetPassword.index')->with(
      ['token' => $token, 'email' => $request->email]
    );
  }

  /**
   * //
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function terminate()
  {
    return view('TAG_GUARD_NAME.resetPassword.index')->with(
      ['token' => '', 'email' => '']
    );
  }

  /**
   * Reset the given user's password.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function reset(Request $request)
  {
    $this->validate($request, $this->rules(), $this->validationErrorMessages());

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $response = $this->broker()->reset(
      $this->credentials($request), function ($user, $password) {
      $this->resetPassword($user, $password);
    }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    return $response == Password::PASSWORD_RESET
      ? $this->sendResetResponse($response)
      : $this->sendResetFailedResponse($request, $response);
  }

  /**
   * Get the password reset validation rules.
   *
   * @return array
   */
  protected function rules()
  {
    return [
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed|min:8',
    ];
  }

  /**
   * Get the response for a successful password reset.
   *
   * @param  string  $response
   * @return \Illuminate\Http\RedirectResponse
   */
  protected function sendResetResponse($response)
  {
    \Session::flash('success', [ trans($response) ]);

    return redirect()->route('TAG_GUARD_NAME.resetPassword.terminate');
  }

  /**
   * Get the broker to be used during password reset.
   *
   * @return \Illuminate\Contracts\Auth\PasswordBroker
   */
  public function broker()
  {
    return Password::broker(AuthInterface::PROVIDER);
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
