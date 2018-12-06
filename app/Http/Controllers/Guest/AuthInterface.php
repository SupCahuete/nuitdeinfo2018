<?php

namespace App\Http\Controllers\Guest;

Interface AuthInterface
{

  /**
   * Guard name of the controller.
   */
  const GUARD = 'guest';

  /**
   * Provider name of the controller.
   */
  const PROVIDER = 'guest';

  /**
   * Guard name of the controller.
   */
  const MIDDLEWARE = 'guest.auth';

  /**
   * Guard name of the controller.
   */
  const MIDDLEWARE_GUEST = 'guest.guest';

}

