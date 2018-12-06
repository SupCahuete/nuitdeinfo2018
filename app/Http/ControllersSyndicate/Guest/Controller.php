<?php

namespace App\Http\ControllersSyndicate\Guest;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

class Controller extends RoutingController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Guard name of the instance.
   *
   * @var string
   */
  protected $guard = NULL;

  /**
   * Attempt to get the guard from the local cache.
   *
   * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard() {
    return Auth::guard($this->guard);
  }

}
