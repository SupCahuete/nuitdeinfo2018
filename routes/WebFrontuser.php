<?php
/*
  |--------------------------------------------------------------------------
  | Frontuser web Routes
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
| Web Frontuser Authentification Routes
|--------------------------------------------------------------------------
*/
Route::get('login', ['as' => 'login.index', 'uses' => 'Frontuser\LoginController@index']);
Route::post('login', ['as' => 'login.store', 'uses' => 'Frontuser\LoginController@login']);
Route::get('register', ['as' => 'register.index', 'uses' => 'Frontuser\RegisterController@index']);
Route::post('register', ['as' => 'register.store', 'uses' => 'Frontuser\RegisterController@register']);

Route::get('password/forgot', ['as' => 'forgotPassword.index', 'uses' => 'Frontuser\ForgotPasswordController@index']);
Route::post('password/forgot/email', ['as' => 'forgotPassword.email', 'uses' => 'Frontuser\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'resetPassword.index', 'uses' => 'Frontuser\ResetPasswordController@index']);
Route::post('password/reset', ['as' => 'resetPassword.reset', 'uses' => 'Frontuser\ResetPasswordController@reset']);

Route::get('logout', ['as' => 'login.logout', 'uses' => 'Frontuser\LoginController@logout']);
/*
|--------------------------------------------------------------------------
*/




/*
|--------------------------------------------------------------------------
| Web Frontuser Routes
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'welcome.index', 'uses' => 'Frontuser\WelcomeController@index']);
Route::get('welcome', ['as' => 'welcome.index', 'uses' => 'Frontuser\WelcomeController@index']);

Route::get('home', ['as' => 'home.index', 'uses' => 'Frontuser\HomeController@index']);
Route::post('home/store', ['as' => 'home.store', 'uses' => 'Frontuser\HomeController@store']);
Route::post('home/update/{id}', ['as' => 'home.update', 'uses' => 'Frontuser\HomeController@update']);

/*TAG_ROUTE*/
/*
|--------------------------------------------------------------------------
*/

