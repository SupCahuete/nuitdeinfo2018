<?php

namespace App\Http\Controllers\Frontuser;

use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

use App\Models\Frontuser;

class RegisterController extends Controller
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
    $this->middleware('guest');

    $this->redirectTo = route('frontuser.home.index');
  }

  /**
   * Show the application registration form.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('frontuser.register.index');
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
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:TABLE_NAME',
      'password' => 'required|min:6|confirmed',
      
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   *
   * @return Frontuser
   */
  protected function create(array $data)
  {
    return Frontuser::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      /*TAG_CREATE_RULES*/
    ]);
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
