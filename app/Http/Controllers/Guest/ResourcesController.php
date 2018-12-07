<?php

namespace App\Http\Controllers\Guest;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
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
    return view('guest.resources.index')->with([
      'resources' => Resource::orderBy('name')->with('type')->get(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int $id
   * @param int $number
   * @return \Illuminate\Http\Response
   */
  public function add(Request $request, $id, $number = 1)
  {
   return $this->adjust($id, $number, '+');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int $id
   * @param $number
   * @return \Illuminate\Http\Response
   */
  public function remove(Request $request, $id, $number = 1)
  {
    return $this->adjust($id, $number, '-');
  }

  /**
   * @param $id
   * @param $number
   * @param $operator
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
   */
  protected function adjust($id, $number, $operator)
  {
    $resource = Resource::find($id);

    if ($operator === '+') {
      $resource->quantity = $resource->quantity + $number;
    }
    elseif ($operator === '-') {
      $resource->quantity = $resource->quantity - $number;
    }

    if ($resource->quantity < 0) {
      $resource->quantity = 0;
    }

    if ($resource->save()) {
      return response()->json([
        'quantity' => $resource->quantity,
      ]);
    }
    else {
      return response(500);
    }
  }
}
