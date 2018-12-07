<?php

namespace App\Http\Controllers\Guest;

use App\Models\Symptom;
use Illuminate\Http\Request;

class HealthController extends Controller
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
    return view('guest.health.index')->with([
      'symptoms' => Symptom::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function heal(Request $request, $id)
  {
    dd($request->all());
  }
}
