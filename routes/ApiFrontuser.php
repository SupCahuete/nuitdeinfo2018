<?php
/*
  |--------------------------------------------------------------------------
  | Frontuser api Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the 'api' middleware group. Now create something great!
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
| Api Frontuser Authentification Routes
|--------------------------------------------------------------------------
*/
Route::post('login', ['as' => 'login.store', 'uses' => 'Api\Frontuser\LoginController@login']);
Route::post('register', ['as' => 'register.store', 'uses' => 'Api\Frontuser\RegisterController@register']);
Route::post('password/forgot/email', ['as' => 'forgotPassword.email', 'uses' => 'Api\Frontuser\ForgotPasswordController@sendResetLinkEmail']);
Route::get('logout', ['as' => 'login.logout', 'uses' => 'Api\Frontuser\LoginController@logout']);
/*
|--------------------------------------------------------------------------
*/




/*
|--------------------------------------------------------------------------
| Api Frontuser Routes
|--------------------------------------------------------------------------
*/

// 

/*TAG_ROUTE*/
/*
|--------------------------------------------------------------------------
*/

