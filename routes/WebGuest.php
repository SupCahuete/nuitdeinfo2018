<?php
/*
  |--------------------------------------------------------------------------
  | Guest web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the 'web' middleware group. Now create something great!
  |


  |--------------------------------------------------------------------------
  |                             Routing Examples
  |--------------------------------------------------------------------------
  Route::get(...) |||| Route::post(...) |||| Route::match(['PUT', 'PATCH'], ...)
  Route::resource('URL_ROUTE_BASE', 'CONTROLLER', [ 'only' => [ACTIONS], 'names' => [ACTIONS] ])

  Route::get('URL_ROUTE', ['as' => 'NAME_ROUTE', 'uses' => 'CONTROLLER@ACTION']);
  Route::get('URL_ROUTE', ['as' => 'NAME_ROUTE', 'uses' => function() {
  ..ACTION
  }]);

  !!-!! With Controller Resource (store, update, destroy, ...) !!-!!
  Route::resource('URL_ROUTE_BASE', 'CONTROLLER', [
  ..'only' => ['ACTION_1', 'ACTION_2'],
  ..'names' => [
  ....'ACTION_1' => 'NAME_ROUTE.ACTION_1',
  ....'ACTION_2' => 'NAME_ROUTE.ACTION_2',
  ..]
  ]);
*/




/*
|--------------------------------------------------------------------------
| Guest routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'welcome.index', 'uses' => function () {
  return view('guest.welcome.index');
}]);

Route::get('resources', ['as' => 'resources.index', 'uses' => 'Guest\ResourcesController@index']);
Route::get('resources/add/{id}/{number?}', ['as' => 'resources.add', 'uses' => 'Guest\ResourcesController@add']);
Route::get('resources/remove/{id}/{number?}', ['as' => 'resources.remove', 'uses' => 'Guest\ResourcesController@remove']);

Route::get('health', ['as' => 'health.index', 'uses' => 'Guest\HealthController@index']);
Route::post('health/heal', ['as' => 'health.heal', 'uses' => 'Guest\HealthController@heal']);

/*TAG_ROUTE*/
/*
|--------------------------------------------------------------------------
*/
