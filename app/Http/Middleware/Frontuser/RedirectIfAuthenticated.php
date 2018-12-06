<?php

namespace App\Http\Middleware\Frontuser;

use Closure;
use Auth;

class RedirectIfAuthenticated
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
   * @param  string|null  $group
   *
   * @return mixed
   */
  public function handle($request, Closure $next, $group = null)
  {
    if (! Auth::guard($this->guard)->guest()) {
      return redirect()->route("$this->guard.home.index");
    }

    return $next($request);
  }
}
