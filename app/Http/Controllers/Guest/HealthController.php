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
   * @param  \App\Http\Requests\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function heal(Request $request)
  {
    $symptoms = Symptom::whereIn('id', $request->symptoms)->with('resources')->get();

    return view('guest.health.result')->with([
      'symptoms' => $symptoms,
    ]);
  }
}
