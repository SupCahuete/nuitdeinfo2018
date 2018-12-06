<?php

namespace App\Http\ControllersSyndicate\Guest;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

use App\Models\Guest;

class Controller extends RoutingController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Guard name of the instance.
   *
   * @var string
   */
  protected $guard = 'guest';

  /**
   * @var string
   */
  protected $userDiskS3 = 'guest';

  /**
   * Attempt to get the guard from the local cache.
   *
   * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard() {
    return Auth::guard($this->guard);
  }

  /**
   * Attempt to get the user from the local cache.
   *
   * @return Guest|null
   */
  protected function user() {
    return $this->guard()->user();
  }

  /**
   * Return Guest model with id attributes.
   *
   * @return Guest
   */
  protected function userModel() {
    return (new Guest())->setAttribute('id', $this->guard()->id());
  }

  /**
   * Return Builder for Guest model.
   *
   * @return Guest
   */
  protected function Guest() {
    return (new Guest());
  }

}
