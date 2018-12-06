<?php

namespace App\Http\Controllers\Api\Frontuser;

Interface AuthInterface
{

  /**
   * Guard name of the controller.
   */
  const GUARD = 'frontuser.api';

  /**
   * Provider name of the controller.
   */
  const PROVIDER = 'frontuser';

  /**
   * Guard name of the controller.
   */
  const MIDDLEWARE = 'frontuser.auth:api';

}

