<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use AdaFile;
use AdaConsole;
use Symfony\Component\Process\Process;

class MakeGuardCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:guard
                            {name : Guard's name ('guest', 'frontuser', 'backuser', 'admin', or 'master').}
                            {group : Group middleware (Supported: web, api or all).}
                            {--data : Specifie if use data in config/consoleData.php}
                            {--all : Active all guards ('frontuser', 'backuser', 'admin', or 'master').}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Make a full guard (Recommandation: 'frontuser', 'backuser', 'admin', or 'master').\nSupports points as directory separator.\nExample: 'auth.login.index' -> 'Auth/Login/index.blade.php'";

  /**
   * Argument 'name'.
   *
   * @var string
   */
  protected $name;

  /**
   * Argument 'group'.
   *
   * @var string
   */
  protected $group;

  /**
   * Middleware group's name.
   *
   * @var string
   */
  protected $groupName;

  /**
   * Guard's name with the first letter in lowercase.
   *
   * @var string
   */
  protected $guardName;

  /**
   * Guard's name with the first letter in uppercase.
   *
   * @var string
   */
  protected $guardNameUpperFirst;

  /**
   * Tag represent middleware group's name.
   *
   * @var string
   */
  protected $middlewareGroup;

  /**
   * Tag represent middleware group's name with the first letter in uppercase.
   *
   * @var string
   */
  protected $middlewareGroupUpperFirst;

  /**
   * Auth controller's tempalte name.
   *
   * @var array
   */
  protected $authControllersNames = ['Login', 'Register', 'ForgotPassword', 'ResetPassword'];

  /**
   * View's name for auth with extend's option.
   *
   * @var array
   */
  protected $viewNamesWithExtendBlade = []; //['SendEmail' => 'email']

  /**
   * Tag represent namespace's name.
   *
   * @var string
   */
  protected $TAG_NAMESPACE_NAME = "TAG_NAMESPACE_NAME";

  /**
   * Tag represent class's name.
   *
   * @var string
   */
  protected $TAG_CLASS_NAME = "TAG_CLASS_NAME";

  /**
   * Tag represent guard's name. Tag used in route file.
   *
   * @var string
   */
  protected $TAG_GUARD_NAME = "TAG_GUARD_NAME";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_GUARD_NAME_UCFIRST = "TAG_GUARD_NAME_UCFIRST";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_GUARD_GROUP_NAME = "TAG_GUARD_GROUP_NAME";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_GUARD_GROUP_NAME_UCFIRST = "TAG_GUARD_GROUP_NAME_UCFIRST";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_ROUTE = "/*TAG_ROUTE*/";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_ROUTE_GROUP;

  /**
   * Tag used in auth config file.
   *
   * @var string
   */
  protected $TAG_GUARD_WEB = "/*TAG_GUARDS_WEB*/";

  /**
   * Tag used in auth config file.
   *
   * @var string
   */
  protected $TAG_GUARD_API = "/*TAG_GUARDS_API*/";

  /**
   * Tag used in auth config file.
   *
   * @var string
   */
  protected $TAG_PASSWORDS = "/*TAG_PASSWORDS*/";

  /**
   * Tag used in auth config file.
   *
   * @var string
   */
  protected $TAG_PROVIDERS = "/*TAG_PROVIDERS*/";

  /**
   * Tag used in route file.
   *
   * @var string
   */
  protected $TAG_ROUTE_AUTH = "/*TAG_ROUTE_AUTH*/";

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return boolean
   */
  public function handle()
  {
    // For the multiple middleware's group.
    if (! $middlewareGroup = $this->middlewareGroup()) return FALSE;

    if($this->option('all')) {
      $guards = ['frontuser', 'backuser', 'admin', 'master'];

      foreach ($middlewareGroup as $group) {
        $this->middlewareGroup = $group;
        $this->middlewareGroupUpperFirst = ucfirst($group);
        $this->TAG_ROUTE_GROUP = "/*TAG_ROUTE_". strtoupper($group) ."*/";

        foreach ($guards as $guard) {
          $this->guardNameUpperFirst = ucfirst($guard);
          $this->guardName = $guard;

          if (! $this->makeGuard()) return FALSE;
        }
      }
    }
    else {
      $exceptGuard = ['front'];

      $this->guardNameUpperFirst = AdaConsole::purgeStrWithMaj($this->argument('name'));
      $this->guardName = lcfirst($this->guardNameUpperFirst);

      if (! in_array(strtolower($this->guardName), $exceptGuard)) {
        foreach ($middlewareGroup as $group) {
          $this->middlewareGroup = $group;
          $this->middlewareGroupUpperFirst = ucfirst($group);
          $this->TAG_ROUTE_GROUP = "/*TAG_ROUTE_". strtoupper($group) ."*/";

          if (! $this->makeGuard()) return FALSE;
        }
      }
      else {
        $this->info("\n\t[ErrorAdaCommand]\n\tGuard '$this->guardName' not accepted (Not supported: 'front').");
        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * Initialization the console command arguments and options.
   *
   * @param string $name
   * @param string $group
   *
   * @return void
   */
  protected function init($name, $group)
  {
    $this->name = $name;
    $this->group = $group;
  }

  /**
   * Initialize the $middlewareGroup.
   *
   * @return boolean|array
   */
  protected function middlewareGroup()
  {
    $acceptMiddlewareGroup = ['web', 'api'];
    $group = strtolower($this->argument('group'));

    if ($group == 'all') {
      $middlewareGroup = ['web', 'api'];
    }
    elseif (in_array($group, $acceptMiddlewareGroup)) {
      $middlewareGroup = [$group];
    }
    else {
      $this->info("\n\t[ErrorAdaCommand]\n\tGroup middleware '$group' not accepted (Supported: 'web', 'api' or 'all').");
      return FALSE;
    }

    return $middlewareGroup;
  }

  /**
   * Make a guard(s).
   *
   * @return boolean
   */
  protected function makeGuard()
  {
    if (! $this->updateConfigAuth()) return FALSE;

    if (! $this->makeRouteFile()) return FALSE;

    if (! $this->updateRouteServiceProvider()) return FALSE;

    if(! $this->makeMiddlewareAuthentication()) return FALSE;

    if (! $this->makeModelAuthentication()) return FALSE;

    if (! $this->makeControllerAuthentication()) return FALSE;

    return TRUE;
  }

  /**
   * Update config/auth.php with new guard.
   *
   * @return boolean
   */
  protected function updateConfigAuth()
  {
    $configAuthPath = base_path("config/auth.php");

    if ($this->middlewareGroup != "api") {
      $driver = "session"; // Define the driver used for the authentification.
      $TAG_GUARD_GROUP = $this->TAG_GUARD_WEB;
      $guardNameWithGroup = $this->guardName;
    }
    else {
      $driver = "token"; // Define the driver used for the authentification.
      $TAG_GUARD_GROUP = $this->TAG_GUARD_API;
      $guardNameWithGroup = "$this->guardName.api";
    }

    // Update TAG_GUARDS.
    $TAG_GUARDS = "\n\t\t'$guardNameWithGroup'  => [\n";
    $TAG_GUARDS .= "\t\t\t'driver' => '$driver',\n";
    $TAG_GUARDS .= "\t\t\t'provider' => '$this->guardName',\n";
    $TAG_GUARDS .= "\t\t],\n";
    $TAG_GUARDS .= "\t\t$TAG_GUARD_GROUP";

    if (! AdaFile::exists(base_path("app/models/$this->guardName.php"))) {
      // Update TAG_PROVIDERS.
      $modelName = ucfirst($this->guardName);
      $TAG_PROVIDERS = "\n\t\t'$this->guardName'  => [\n";
      $TAG_PROVIDERS .= "\t\t\t'driver' => 'eloquent',\n";
      $TAG_PROVIDERS .= "\t\t\t'model' => App\\Models\\{$modelName}::class,\n";
      $TAG_PROVIDERS .= "\t\t],\n";
      $TAG_PROVIDERS .= "\t\t$this->TAG_PROVIDERS";

      // Update TAG_PASSWORDS.
      $guardNamePlurial = str_plural($this->guardName);
      $TAG_PASSWORDS = "\n\t\t'$this->guardName'  => [\n";
      $TAG_PASSWORDS .= "\t\t\t'provider' => '$this->guardName',\n";
      $TAG_PASSWORDS .= "\t\t\t'table' => '{$guardNamePlurial}_password_resets',\n";
      $TAG_PASSWORDS .= "\t\t\t'expire' => '60',\n";
      $TAG_PASSWORDS .= "\t\t],\n";
      $TAG_PASSWORDS .= "\t\t$this->TAG_PASSWORDS";
    }
    else {
      // Update TAG_PROVIDERS.
      $TAG_PROVIDERS = $this->TAG_PROVIDERS;

      // Update TAG_PASSWORDS.
      $TAG_PASSWORDS = $this->TAG_PASSWORDS;
    }

    // Prepare content file.
    $content = AdaFile::get($configAuthPath);
    $content = str_replace($TAG_GUARD_GROUP, $TAG_GUARDS, $content);
    $content = str_replace($this->TAG_PROVIDERS, $TAG_PROVIDERS, $content);
    $content = str_replace($this->TAG_PASSWORDS, $TAG_PASSWORDS, $content);

    // Create file.
    AdaFile::put($configAuthPath, $content);
    $this->info("\nConfig Auth updating $this->guardName updated.\nPath: $configAuthPath");
    return TRUE;
  }
  
  /**
   * Make a route file with authentication's routes.
   *
   * @return boolean
   */
  protected function makeRouteFile()
  {
    $nameFile = ucfirst($this->middlewareGroup) . $this->guardNameUpperFirst;
    $routePath = base_path("routes/$nameFile.php");

    if (AdaFile::exists($routePath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tFile $nameFile already exists!\n\tPath: $routePath");
      return FALSE;
    }

    // Initialize the $route variable.
    $route = $this->routeAuth();

    // Prepare content file.
    $content = AdaFile::get(dirname(__FILE__) . "/../Templates/Routes/Guard.php");
    $content = str_replace($this->TAG_GUARD_NAME_UCFIRST, $this->guardNameUpperFirst, $content);
    $content = str_replace($this->TAG_GUARD_GROUP_NAME, $this->middlewareGroup, $content);
    $content = str_replace($this->TAG_ROUTE_AUTH, "\n\n\n\n".$route->auth, $content);
    $content = str_replace($this->TAG_ROUTE, "\n\n\n".$route->additional, $content);

    // Create file.
    AdaFile::put($routePath, $content);
    $this->info("\nRoute file $nameFile created.\nPath: $routePath");
    return TRUE;
  }

  /**
   * Update RouteServiceProvider with new guard.
   *
   * @return boolean
   */
  protected function updateRouteServiceProvider()
  {
    $routeServiceProviderPath = base_path("app/Providers/RouteServiceProvider.php");
    $middlewareGroupUpperFirst = ucfirst($this->middlewareGroup);

    $preUrl = $this->middlewareGroup == 'api' ? "api/" : '';
    $pre = $this->middlewareGroup == 'api' ? "api." : '';

    // Update TAG_ROUTE.
    $TAG_ROUTE = "\n\t\tRoute::group([\n";
    $TAG_ROUTE .= "\t\t\t'middleware' => '{$this->middlewareGroup}',\n";
    $TAG_ROUTE .= "\t\t\t'namespace' => \$this->namespace,\n";
    $TAG_ROUTE .= "\t\t\t'prefix' => '{$preUrl}{$this->guardName}', // {$pre}{$this->guardName}\n";
    $TAG_ROUTE .= "\t\t\t'as' => '{$pre}{$this->guardName}.', // {$pre}{$this->guardName} - Modifications are to be expected after the begining of the developement.\n";
    $TAG_ROUTE .= "\t\t], function (\$router) {\n";
    $TAG_ROUTE .= "\t\t\trequire base_path('routes/{$middlewareGroupUpperFirst}{$this->guardNameUpperFirst}.php');\n";
    $TAG_ROUTE .= "\t\t});\n";
    $TAG_ROUTE .= "\t\t$this->TAG_ROUTE_GROUP";

    // Prepare content file.
    $content = AdaFile::get($routeServiceProviderPath);
    $content = str_replace($this->TAG_ROUTE_GROUP, $TAG_ROUTE, $content);

    // Create file.
    AdaFile::put($routeServiceProviderPath, $content);
    $this->info("\nRouteServiceProvider updated.\nPath: $routeServiceProviderPath");
    return TRUE;
  }

  /**
   * Make a authentificate's middleware.
   *
   * @return boolean
   */
  protected function makeMiddlewareAuthentication()
  {
    // Create Authenticate middleware for the guard.
    $process = new Process("php adn make:middleware Authenticate --guard=$this->guardName --template=authenticate --route=auth");
    $process->run();
    echo $process->getOutput();
    if (! $process->isSuccessful()) return FALSE;

    // Create RedirectIfAuthenticated middleware for the guard.
    $process = new Process("php adn make:middleware RedirectIfAuthenticated --guard=$this->guardName --template=RedirectIfAuthenticated --route=guest");
    $process->run();
    echo $process->getOutput();
    if (! $process->isSuccessful()) return FALSE;

    return TRUE;
  }

  /**
   * Make the authentication's model.
   *
   * @return boolean
   */
  protected function makeModelAuthentication()
  {
    $data = $this->option('data') ? '--data' : '';

    // Create RedirectIfAuthenticated middleware for the guard.
    $process = new Process("php adn make:model $this->guardName --auth $data");
    $process->run();
    echo $process->getOutput();
    if (! $process->isSuccessful()) return FALSE;

    return TRUE;
  }

  /**
   * Make authentication's controllers.
   *
   * @return boolean
   */
  protected function makeControllerAuthentication()
  {
    // Controller who uses the data in 'config/consoleData.php'.
    $controllerWithData = ['register'];

    // Create auth's controllers.
    foreach ($this->authControllersNames as $name) {
      $data =
        ( in_array(strtolower($name), $controllerWithData) and $this->option('data') ) ?
          '--data' :
          '';
          
      $process = new Process("php adn make:controller $name --auth --guard=$this->guardName --group=$this->middlewareGroup --template=$name --singular --noroute $data");
      $process->run();
      echo $process->getOutput();
      if (! $process->isSuccessful()) return FALSE;
    }

    if ($this->middlewareGroup != 'api') {
      // Create welcome's controller.
      $process = new Process("php adn make:controller welcome --guard=$this->guardName --group=$this->middlewareGroup --singular --guest");
      $process->run();
      echo $process->getOutput();
      if (! $process->isSuccessful()) return FALSE;

      // Create home's controller.
      $process = new Process("php adn make:controller home --guard=$this->guardName --group=$this->middlewareGroup --singular");
      $process->run();
      echo $process->getOutput();
      if (! $process->isSuccessful()) return FALSE;
    }

    return TRUE;
  }

  /**
   * Prepare the authentication route for the content file.
   *
   * @return \stdClass
   */
  protected function routeAuth()
  {

    if ($this->middlewareGroup == 'api') { // Prepare the authenticate routes with 'api' middleware group.
      $routeAuth = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Authentification Routes
|--------------------------------------------------------------------------
*/
Route::post('login', ['as' => 'login.store', 'uses' => 'Api\\$this->guardNameUpperFirst\\LoginController@login']);
Route::post('register', ['as' => 'register.store', 'uses' => 'Api\\$this->guardNameUpperFirst\\RegisterController@register']);
Route::post('password/forgot/email', ['as' => 'forgotPassword.email', 'uses' => 'Api\\$this->guardNameUpperFirst\\ForgotPasswordController@sendResetLinkEmail']);
Route::post('logout', ['as' => 'login.logout', 'uses' => 'Api\\$this->guardNameUpperFirst\\LoginController@logout']);
/*
|--------------------------------------------------------------------------
*/
EOF;


      $routeAdd = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Routes
|--------------------------------------------------------------------------
*/
\n// \n
$this->TAG_ROUTE
/*
|--------------------------------------------------------------------------
*/
EOF;

    }
    elseif ($this->middlewareGroup == 'web') { // Prepare the authenticate routes with 'web' middleware group.
      $routeAuth = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Authentification Routes
|--------------------------------------------------------------------------
*/
Route::get('login', ['as' => 'login.index', 'uses' => '$this->guardNameUpperFirst\\LoginController@index']);
Route::post('login', ['as' => 'login.store', 'uses' => '$this->guardNameUpperFirst\\LoginController@login']);
Route::get('register', ['as' => 'register.index', 'uses' => '$this->guardNameUpperFirst\\RegisterController@index']);
Route::post('register', ['as' => 'register.store', 'uses' => '$this->guardNameUpperFirst\\RegisterController@register']);
Route::get('password/forgot', ['as' => 'forgotPassword.index', 'uses' => '$this->guardNameUpperFirst\\ForgotPasswordController@index']);
Route::post('password/forgot/email', ['as' => 'forgotPassword.email', 'uses' => '$this->guardNameUpperFirst\\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'resetPassword.index', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@index']);
//Route::get('password/reset', ['as' => 'resetPassword.terminate', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@terminate']);
Route::post('password/reset', ['as' => 'resetPassword.reset', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@reset']);
Route::get('logout', ['as' => 'login.logout', 'uses' => '$this->guardNameUpperFirst\\LoginController@logout']);
/*
|--------------------------------------------------------------------------
*/
EOF;


      $routeAdd = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Routes
|--------------------------------------------------------------------------
*/
$this->TAG_ROUTE
/*
|--------------------------------------------------------------------------
*/
EOF;

    }
    else { // Prepare the authenticate routes without middleware group.
      $routeAuth = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Authentification Routes
|--------------------------------------------------------------------------
*/
//Route::get('login', ['as' => 'login.index', 'uses' => '$this->guardNameUpperFirst\\LoginController@index']);
//Route::post('login', ['as' => 'login.store', 'uses' => '$this->guardNameUpperFirst\\LoginController@login']);
//Route::get('register', ['as' => 'register.index', 'uses' => '$this->guardNameUpperFirst\\RegisterController@index']);
//Route::post('register', ['as' => 'register.store', 'uses' => '$this->guardNameUpperFirst\\RegisterController@register']);
//Route::get('password/forgot', ['as' => 'forgotPassword.index', 'uses' => '$this->guardNameUpperFirst\\ForgotPasswordController@index']);
//Route::post('password/forgot/email', ['as' => 'forgotPassword.email', 'uses' => '$this->guardNameUpperFirst\\ForgotPasswordController@sendResetLinkEmail']);
//Route::get('password/reset/{token}', ['as' => 'resetPassword.index', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@index']);
//Route::get('password/reset', ['as' => 'resetPassword.terminate', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@terminate']);
//Route::post('password/reset', ['as' => 'resetPassword.reset', 'uses' => '$this->guardNameUpperFirst\\ResetPasswordController@reset']);
//Route::get('logout', ['as' => 'login.logout', 'uses' => '$this->guardNameUpperFirst\\LoginController@logout']);
/*
|--------------------------------------------------------------------------
*/
EOF;
      $routeAdd = <<<EOF
/*
|--------------------------------------------------------------------------
| $this->middlewareGroupUpperFirst $this->guardNameUpperFirst Routes
|--------------------------------------------------------------------------
*/
$this->TAG_ROUTE
/*
|--------------------------------------------------------------------------
*/
EOF;

    }

    $route = new \stdClass();
    $route->auth = $routeAuth;
    $route->additional = $routeAdd;
    return $route;
  }
}
