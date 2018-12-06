<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * This namespace is applied to your controller routes.
   *
   * In addition, it is set as the URL generator's root namespace.
   *
   * @var string
   */
  protected $namespace = 'App\Http\Controllers';

  /**
   * Define your route model bindings, pattern filters, etc.
   *
   * @return void
   */
  public function boot()
  {
    //

    parent::boot();
  }

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map()
  {
    $this->mapApiRoutes();

    $this->mapWebRoutes();

    //
  }

  /**
   * Define the "web" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
  protected function mapWebRoutes()
  {
//    Route::middleware('web')
//      ->namespace($this->namespace)
//      ->group(base_path('routes/web.php'));

    Route::group([
      'middleware' => 'web',
      'namespace' => $this->namespace,
      'as' => 'guest.', // Modifications are to be expected after the begining of the developement.
    ], function ($router) {
      require base_path('routes/WebGuest.php');
    });

    Route::group([
      'middleware' => 'web',
      'namespace' => $this->namespace,
      'prefix' => 'frontuser', // client
      'as' => 'frontuser.', // frontuser - Modifications are to be expected after the begining of the developement.
    ], function ($router) {
      require base_path('routes/WebFrontuser.php');
    });
    /*TAG_ROUTE_WEB*/
  }

  /**
   * Define the "api" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function mapApiRoutes()
  {
//    Route::prefix('api')
//      ->middleware('api')
//      ->namespace($this->namespace)
//      ->group(base_path('routes/api.php'));

    Route::group([
      'middleware' => 'api',
      'namespace' => $this->namespace,
      'prefix' => 'api',
      'as' => 'api.guest.', // Modifications are to be expected after the beginin of the developement.
    ], function ($router) {
      require base_path('routes/ApiGuest.php');
    });

    Route::group([
      'middleware' => 'api',
      'namespace' => $this->namespace,
      'prefix' => 'api.frontuser', // api.frontuser
      'as' => 'api.frontuser.', // api.frontuser - Modifications are to be expected after the begining of the developement.
    ], function ($router) {
      require base_path('routes/ApiFrontuser.php');
    });
    /*TAG_ROUTE_API*/
  }
}
