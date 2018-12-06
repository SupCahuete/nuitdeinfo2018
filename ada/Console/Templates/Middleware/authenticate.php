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
   * @param  string $guard
   *
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = NULL)
  {
    if ($guard === 'api') { // api middleware group.
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
    
       return redirect()->route("$this->guard.login.index");
     }
    
     return $next($request);
    }
  }
}
