<?php
/*
  |--------------------------------------------------------------------------
  | TAG_GUARD_NAME_UCFIRST TAG_GUARD_GROUP_NAME Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the 'TAG_GUARD_GROUP_NAME' middleware group. Now create something great!
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
/*TAG_ROUTE_AUTH*/
/*TAG_ROUTE*/
