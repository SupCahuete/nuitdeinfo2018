<?php

namespace App\Http\Controllers\Frontuser;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('frontuser.welcome.index');
  }
}
