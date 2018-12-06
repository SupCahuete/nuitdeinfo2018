<?php

namespace TAG_NAMESPACE_NAME;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
/*TAG_USE*/
class TAG_CLASS_NAME extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
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
    $this->middleware(AuthInterface::MIDDLEWARE_GUEST);

    $this->redirectTo = route('TAG_GUARD_NAME.home.index');
    $this->registerView = 'TAG_GUARD_NAME.register.index';
  }

  /**
   * Show the application registration form.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('TAG_GUARD_NAME.register.index');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   *
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'first_name' => 'required|max:60',
      'last_name' => 'required|max:60',
      'email' => 'required|email|max:255|unique:TAG_TABLE_NAME',
      'password' => 'required|min:8|confirmed',
      /*TAG_VALIDATOR_RULES*/
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   *
   * @return TAG_MODEL_NAME
   */
  protected function create(array $data)
  {
    return TAG_MODEL_NAME::create([
      'id' => TAG_MODEL_NAME::uuid4(),
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      'api_token' => TAG_MODEL_NAME::getNewApiToken(),
      /*TAG_CREATE_RULES*/
    ]);
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
