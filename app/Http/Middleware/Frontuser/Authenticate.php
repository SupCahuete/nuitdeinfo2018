<?php

namespace app\Http\Middleware\Frontuser;

use Closure;
use Auth;

class Authenticate
{
  /*
   * Default guard for this authentication's middleware.
   */
  private $guard = 'frontuser';

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string  $group
   *
   * @return mixed
   */
  public function handle($request, Closure $next, $group = NULL)
  {
    if ($group === 'api') { // api middleware group.
      if (Auth::guard("$this->guard.api")->guest()) {
        return response('Unauthorized.', 401);
      }

      return $next($request);
    }
    else { // web middleware group.
      if (Auth::guard($this->guard)->guest()) {
        /*
         * Ajax ant Json request blocked
         */
        if ($request->ajax() || $request->wantsJson()) {
          return response('Unauthorized.', 401);
        }

        return redirect()->route('frontuser.login.index');
      }

      return $next($request);
    }
  }
}
