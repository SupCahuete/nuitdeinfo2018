<?php

namespace App\Http\Controllers\Guest;

use App\Http\ControllersSyndicate\Guest\Controller as BaseController;

class Controller extends BaseController
{

  /**
   * Guard name of the controller.
   *
   * @var string
   */
  protected $guard = AuthInterface::GUARD;

}
