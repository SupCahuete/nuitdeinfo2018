<?php

namespace App\Http\Controllers\Api\Frontuser;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Lang;

use App\Models\Frontuser;

use Ada\Assistants\Traits\ApiAssistant;

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

  use AuthenticatesUsers, ApiAssistant;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(AuthInterface::MIDDLEWARE, ['only' => 'logout']);
  }

  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required',
    ]);

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if ($this->hasTooManyLoginAttempts($request)) {
      $this->fireLockoutEvent($request);

      return $this->responseFail();
    }

    $credentials = $this->credentials($request);

    /** @var Frontuser $user */
    $user = $this->guard()->attempt($credentials);

    if ($user) {
      $api_token = str_random(60);

      $user->api_token = $api_token;

      if ($user->save()) {
        return $this->response(['api_token' => $api_token]);
      }
      else {
        return $this->responseError();
      }
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->responseFail();
  }

  /** Override
   * Log the user out of the application.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    $this->guard()->logout();

    return $this->response();
  }

  /** Override
   * Get the failed login response instance.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function sendFailedLoginResponse(Request $request)
  {
    return $this->responseFail([
      'message' =>  Lang::get('auth.failed')
    ]);
  }
}
