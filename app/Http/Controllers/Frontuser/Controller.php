<?php

namespace App\Http\Controllers\Frontuser;

use App\Http\ControllersSyndicate\Frontuser\Controller as BaseController;

class Controller extends BaseController
{

  /**
   * Guard name of the controller.
   *
   * @var string
   */
  protected $guard = AuthInterface::GUARD;

}
