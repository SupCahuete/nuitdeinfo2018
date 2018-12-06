<?php

namespace App\Http\ControllersSyndicate\Frontuser;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

use App\Models\Frontuser;

class Controller extends RoutingController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Guard name of the instance.
   *
   * @var string
   */
  protected $guard = 'frontuser';

  /**
   * @var string
   */
  protected $userDiskS3 = 'frontuser-s3';

  /**
   * @var array
   */
  protected $attributesBase = [
    // id
    'id',

    // Auth
    'email',

    // base
    'first_name',
    'last_name',
  ];

  /**
   * Attempt to get the guard from the local cache.
   *
   * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard() {
    return Auth::guard($this->guard);
  }

  /**
   * Find a model by its primary key.
   *
   * @param array $columns
   *
   * @return Frontuser
   */
  protected function user( $columns = ['*'] ) {
    return Frontuser::find($this->guard()->id(), $columns);
  }

  /**
   * Find a model by its primary key.
   *
   * @param array $columns
   *
   * @return Frontuser
   */
  protected function userBase( $adds = NULL ) {
    $columns = $this->attributesBase;

    if (! is_null($adds)) {
      $columns = array_merge($columns, $adds);
    }

    return Frontuser::find($this->guard()->id(), $columns);
  }

  /**
   * Return Frontuser model with id attributes.
   *
   * @return Frontuser
   */
  protected function userModel() {
    return (new Frontuser())->setAttribute('id', $this->guard()->id());
  }

  /**
   * Return Builder with 'where' id condition.
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  protected function frontuser() {
    return (new Frontuser())->where('id', '=', $this->guard()->id());
  }

}
