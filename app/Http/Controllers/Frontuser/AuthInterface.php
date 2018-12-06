<?php

namespace App\Http\Controllers\Frontuser;

Interface AuthInterface
{

  /**
   * Guard name of the controller.
   */
  const GUARD = 'frontuser';

  /**
   * Provider name of the controller.
   */
  const PROVIDER = 'frontuser';

  /**
   * Guard name of the controller.
   */
  const MIDDLEWARE = 'frontuser.auth';

}

