<?php

namespace TAG_NAMESPACE_NAME;

use Closure;
use Auth;

class TAG_CLASS_NAME
{
  /*
   * Default guard for this authentication's middleware.
   */
  private $guard = 'TAG_GUARD_NAME';

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   *
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    if (! Auth::guard($this->guard)->guest()) {
      return redirect()->route("$this->guard.home.index");
    }

    return $next($request);
  }
}
