<?php

namespace App\Http\ControllersSyndicate\TAG_GUARD_NAME_UCFIRST;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

use App\Models\TAG_GUARD_NAME_UCFIRST;

class Controller extends RoutingController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Guard name of the instance.
   *
   * @var string
   */
  protected $guard = 'TAG_GUARD_NAME';

  /**
   * @var string
   */
  protected $userDiskS3 = 'TAG_GUARD_NAME';

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
   * @return TAG_GUARD_NAME_UCFIRST|null
   */
  protected function user() {
    return $this->guard()->user();
  }

  /**
   * Return TAG_GUARD_NAME_UCFIRST model with id attributes.
   *
   * @return TAG_GUARD_NAME_UCFIRST
   */
  protected function userModel() {
    return (new TAG_GUARD_NAME_UCFIRST())->setAttribute('id', $this->guard()->id());
  }

  /**
   * Return Builder for TAG_GUARD_NAME_UCFIRST model.
   *
   * @return TAG_GUARD_NAME_UCFIRST
   */
  protected function TAG_GUARD_NAME_UCFIRST() {
    return (new TAG_GUARD_NAME_UCFIRST());
  }

}
