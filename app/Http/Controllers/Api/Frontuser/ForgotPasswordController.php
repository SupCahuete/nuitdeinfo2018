<?php

namespace App\Http\Controllers\Api\Frontuser;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Display the form to request a password reset link.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('frontuser.forgotPassword.index');
  }

  /**
   * Send a reset link to the given user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function email(Request $request)
  {
    $this->validate($request, ['email' => 'required|email']);

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $response = $this->broker()->sendResetLink(
      $request->only('email')
    );

    return $response == Password::RESET_LINK_SENT
      ? $this->sendResetLinkResponse($response)
      : $this->sendResetLinkFailedResponse($request, $response);
  }

  /**
   * Get the response for a successful password reset link.
   *
   * @param  string  $response
   * @return \Illuminate\Http\RedirectResponse
   */
  protected function sendResetLinkResponse($response)
  {
    return back()->with('success', [ trans($response) ]);
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
}
