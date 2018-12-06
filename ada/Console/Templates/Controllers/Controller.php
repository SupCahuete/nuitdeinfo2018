<?php

namespace TAG_NAMESPACE_NAME;

use App\Http\ControllersSyndicate\TAG_GUARD_NAME_UCFIRST\Controller as BaseController;

class Controller extends BaseController
{

  /**
   * Guard name of the controller.
   *
   * @var string
   */
  protected $guard = AuthInterface::GUARD;

}
