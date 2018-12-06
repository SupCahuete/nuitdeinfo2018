<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;
use AdaConsole;
use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

class MakeControllerCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:controller
                            {name : Controller's name (Words not accepts -> controller, controllers, control, controls).}
                            {--template= : Template used.}
                            {--group= : Group middleware (Supported: web or api).}
                            {--guard= : Define the application guard ('guest', 'frontuser', 'backuser', 'admin', or 'master'), by default 'guest' is used.}
                            {--viewExtend= : Choose the view's extend template for blade.}
                            {--viewAll : Add a view for index, create and edit method.}
                            {--noview : Disable make view.}
                            {--guest : Specify if you don't use authenticate's middleware (access in guest).}
                            {--data : Specify if the command should use the data in config/consoleData.php}
                            {--auth : Authentication's option for make:guard command.}
                            {--singular : Disable auto plural.}
                            {--noroute : Disable make route.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Create a new controller in 'app/Http/Controller/*' and a view(s) in resources/assets/views/lang-dev/*";

  /**
   * Argument 'name'.
   *
   * @var string
   */
  protected $name;

  /**
   * Option 'template'.
   *
   * @var string
   */
  protected $template;

  /**
   * Option 'guard'.
   *
   * @var string
   */
  protected $guard;

  /**
   * Option 'group'.
   *
   * @var string
   */
  protected $group;

  /**
   * Option 'viewExtend'.
   *
   * @var string
   */
  protected $viewExtend;

  /**
   * Controller's name.
   *
   * @var string
   */
  protected $controllerName;

  /**
   * Controller's name with the first letter in uppercase.
   *
   * @var string
   */
  protected $controllerNameUpperFirst;

  /**
   * Controller's full path.
   *
   * @var string
   */
  protected $controllerPath;

  /**
   * Controller class's name.
   *
   * @var string
   */
  protected $controllerClassName;

  /**
   * Controller namespase.
   *
   * @var string
   */
  protected $controllerNamespace;

  /**
   * Option template's name.
   *
   * @var string
   */
  protected $templateName;

  /**
   * Option template's path.
   *
   * @var string
   */
  protected $templatePath;

  /**
   * Controller's template extention.
   *
   * @var string
   */
  protected $templateExtention = ".php";

  /**
   * Option guard's name.
   *
   * @var string
   */
  protected $guardName;

  /**
   * Option guard's name with the first letter in uppercase.
   *
   * @var string
   */
  protected $guardNameUpperFirst;

  /**
   * Middleware group's name
   *
   * @var string
   */
  protected $middlewareGroupName;

  /**
   * Guard's folder path.
   *
   * @var string
   */
  protected $guardDirPath;

  /*
   * Content a tag use string.
   *
   * @var string
   */
  protected $tagUse = "";

  /**
   * Tag in route file.
   *
   * @var string
   */
  protected $TAG_ROUTE = "/*TAG_ROUTE*/";

  /**
   * Create a new command instance.
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return void
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  public function handle()
  {
    $this->init(
      $this->argument('name'),
      $this->option('template'),
      $this->option('guard'),
      $this->option('group'),
      $this->option('viewExtend')
    );

    $nameNotAcceped = ['controller', 'controllers'];
    $name = AdaConsole::purgeStrWithMaj($this->name, $nameNotAcceped);

    // Check string after purge from controller's name.
    if ($name == "") {
      $this->error("\n\t[ErrorAdaCommand]\n\tName {$this->name} is not valid !\n\tNot accepted:");

      foreach ($nameNotAcceped as $name) {
        $this->error("\n\t\t$name");
      }

      return;
    }

    if ($this->option('singular')) {
      $this->controllerNameUpperFirst = str_singular($name);
      $this->controllerName = lcfirst($this->controllerNameUpperFirst);
    }
    else {
      $this->controllerNameUpperFirst = str_plural($name);
      $this->controllerName = lcfirst($this->controllerNameUpperFirst);
    }

    // Set guard's names.
    if (! $this->guard()) return;

    // Set middleware group's names.
    if (! $this->middlewareGroup()) return;

    // Initialize guard's path.
    $this->guardDirPath = base_path(
      "app/Http/Controllers/"
      . ($this->middlewareGroupName == 'api' ? "Api/" : "")
      . $this->guardNameUpperFirst
    );

    // Initialize controller class's name and path.
    $this->controllerClassName = $this->controllerNameUpperFirst . "Controller";
    $this->controllerPath = "{$this->guardDirPath}/$this->controllerClassName.php";

    // Check if the controller already exist.
    if (AdaFile::exists($this->controllerPath))
    {
      $this->error("\n\t[ErrorAdaCommand]\n\tFile $this->controllerClassName already exists!\n\tPath: $this->controllerPath");
      return;
    }

    // Initialize controller's namespace.
    $this->controllerNamespace =
      "App\\Http\\Controllers\\"
      . ($this->middlewareGroupName == 'api' ? "Api\\" : "")
      . $this->guardNameUpperFirst;

    // Get content template.
    if ($this->option('auth')) {
      if (! $content = $this->authenticationController()) return;
    }
    else {
      if (! $content = $this->standardController()) return;

      if (! $this->option('noroute')) {
        if (! $this->updateRouteController()) return;
      }
    }

    // Prepare controller file content.
    $content = str_replace("TAG_NAMESPACE_NAME", $this->controllerNamespace, $content);
    $content = str_replace("/*TAG_USE*/", $this->tagUse, $content);
    $content = str_replace("TAG_CLASS_NAME", $this->controllerClassName, $content);

    // Create the guard's directory for the controller.
    if (! AdaFile::exists($this->guardDirPath)) {
      if (AdaFile::makeDir($this->guardDirPath, 0755)) {
        $this->makeBaseGuard();
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tNot create directory '$this->guardDirPath'.");
        return;
      }
    }

    // Create file.
    AdaFile::put($this->controllerPath, $content);

    // Display success.
    $this->info("\nController $this->controllerClassName created.\nPath: $this->controllerPath");

    // Make view(s).
    if ( ( !$this->option('noview') or $this->option('auth') ) and $this->middlewareGroupName != 'api') {
      $this->makeView();
    }
  }

  /**
   * Initialization the console command arguments and options.
   *
   * @param string $name
   * @param string $template
   * @param string $guard
   * @param string $group
   * @param string $viewExtend
   *
   * @return void
   */
  protected function init($name, $template = NULL, $guard = NULL, $group = NULL, $viewExtend = NULL) {
    $this->name = $name;

    $this->template = $template;

    $this->guard = $guard;

    $this->group = $group;

    $this->viewExtend = $viewExtend;
  }

  /**
   * Set the guard's names.
   *
   * @return boolean
   */
  protected function guard()
  {
    if ($this->guard) {
      $this->guardNameUpperFirst = AdaConsole::purgeStrWithMaj($this->guard);
      $this->guardName = lcfirst($this->guardNameUpperFirst);
    }
    else {
      $this->guardNameUpperFirst = "Guest";
      $this->guardName = "guest";
    }

    return TRUE;
  }

  /**
   * Set midddleware group's name.
   *
   * @return boolean
   */
  protected function middlewareGroup()
  {
    if ($middlewareGroupName = $this->group) {
      $acceptGroupMiddleware = ['web', 'api'];

      $this->middlewareGroupName = strtolower($middlewareGroupName);

      if (! in_array($this->middlewareGroupName, $acceptGroupMiddleware)) {
        $this->info("\n\t[ErrorAdaCommand]\n\tGroup middleware '$this->middlewareGroupName' not accepted (Supported: 'web' or 'api').");
        return FALSE;
      }
    }
    else {
      $this->middlewareGroupName = 'web';
    }

    return TRUE;
  }

  /**
   * Prepare authentication's controller file content.
   *
   * @return boolean|string
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  protected function authenticationController()
  {
    if (! $this->guard) {
      $this->error("\n\t[ErrorAdaCommand]\n\tOption 'auth' needs option 'guard'");
      return FALSE;
    }

    if (! $this->template ) {
      $this->error("\n\t[ErrorAdaCommand]\n\tOption 'auth' needs option 'template'");
      return FALSE;
    }

    // Initialize the model's name.
    $modelName = $this->model();

    // Initialize the template's name and path.
    $this->template("Auth");

    // Prepare content file.
    $content = AdaFile::get($this->templatePath);
    $content = str_replace("TAG_GUARD_NAME", $this->guardName, $content);
    $content = str_replace("TAG_MODEL_NAME", $modelName, $content);
    $content = str_replace("TAG_TABLE_NAME", snake_case(str_plural($this->guardName)), $content);

    if ($this->option('data'))
    {
      $guardNameConfig = str_plural($this->guardName);
      $databaseData = NULL;

      if (! ($fillableData = config("consoleData.$guardNameConfig.model.fillable")) ) {
        if ($fillableData = config("consoleData.$guardNameConfig.database")) {
          $fillableData = array_keys($fillableData);
          $databaseData = $fillableData;
          $fillableData = array_merge(['id'], $fillableData);
        }
      }

      if ($fillableData ) {
        $except = ['name', 'email', 'password'];
        $rules = "";

        foreach ($fillableData as $key) {
          if (! in_array($key, $except)) {
            $rules .= "'{$key}' => 'required',\n\t\t\t";
          }
        }

        $content = str_replace("/*TAG_VALIDATOR_RULES*/", $rules, $content);
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tconfig('consoleData.$guardNameConfig.model.fillable') return null.\n\tCheck if 'model.fillable' exist in config\\consoleData.php");
        return FALSE;
      }

      $databaseData = $databaseData ?? config("consoleData.$guardNameConfig.model.database", FALSE);

      if ($databaseData) {
        $except = ['name', 'email', 'password'];
        $rules = "";

        foreach ($fillableData as $key) {
          if (! in_array($key, $except)) {
            $rules .= "'$key' => data['$key'],\n\t\t\t";
          }
        }

        $content = str_replace("/*TAG_VALIDATOR_RULES*/", $rules, $content);
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tconfig('consoleData.$guardNameConfig.model.database return null.\n\tCheck if they exist in config\\consoleData.php");
        return FALSE;
      }
    }
    else {
      $content = str_replace("/*TAG_VALIDATOR_RULES*/", "", $content);
      $content = str_replace("/*TAG_VALIDATOR_RULES*/", "", $content);
    }

    return $content;
  }

  /**
   * Prepare content's standard controller.
   *
   * @return boolean|string
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  protected function standardController()
  {
    // Initialize the constructor's tag.
    if ($this->guardName != 'guest' and ! $this->option('guest')) {
      $tagConstructor = "\$this->middleware(AuthInterface::MIDDLEWARE);";
    }
    else {
      $tagConstructor = "//";
    }

    if ($this->option('data')) {
      // Model import.
      if (! $this->model()) return FALSE;

      // Request Store import.
      if (! $requestStoreName = $this->requestStore()) return FALSE;

      // Request Update import.
      if (! $requestUpdateName = $this->requestUpdate()) return FALSE;

      $tagArgumentStore = "$requestStoreName \$request";
      $tagArgumentUpdate = "$requestUpdateName \$request, \$id";
    }
    else {
      $this->tagUse = "";
      $tagArgumentStore = "Request \$request";
      $tagArgumentUpdate = "Request \$request, \$id";
    }

    // Set the template's name and path.
    $this->template();

    // Prepare content file.
    $content = AdaFile::get($this->templatePath);
    $content = str_replace("TAG_CLASS_NAME", $this->controllerClassName, $content);
    $content = str_replace("/*TAG_CONSTRUCTOR*/", $tagConstructor, $content);

    $content = str_replace("/*TAG_ARGUMENTS_STORE*/", $tagArgumentStore, $content);
    $content = str_replace("/*TAG_ARGUMENTS_UPDATE*/", $tagArgumentUpdate, $content);

    if ($this->middlewareGroupName == 'api') {
      $content = str_replace("/*TAG_INDEX*/", "//", $content);
    }
    else {
      $content = str_replace("/*TAG_INDEX*/", "return view('$this->guardName.$this->controllerName.index');", $content);
    }

    return $content;
  }

  /**
   * Prepare the model's data.
   *
   * @return boolean
   */
  protected function model()
  {
    if ($this->option('auth')) {
      $modelName = str_singular($this->guardNameUpperFirst);
    }
    else {
      $modelName = str_singular($this->controllerNameUpperFirst);
    }

    $modelPath = base_path("app/Models/$modelName.php");

    if (! AdaFile::exists($modelPath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tModel '$modelName' not exists!\n\tPath: $modelPath");
      return FALSE;
    }

    $this->tagUse .= "use App\\Models\\$modelName;\n";

    return $modelName;
  }

  /**
   * Set the template's name and path.
   *
   * @param string $path
   *
   * @return bool
   */
  protected function template($path = '')
  {
    if ($path != '') {
      // Normalize the directory separator.
      $path = AdaFile::normalizePath($path);

      // Clean the path beginning.
      $path = str_start_clear($path, ['/', '\\', '.']);

      // Add a slash to end the path if he does not have one.
      $path = str_finish($path, '/');
    }

    // If the template is null, $templateName will take the value 'default',
    // except if the 'auth' option exist.
    // If the 'auth' option exist, 'templateName' will be null.
    if (! $this->templateName = $this->template and ! $this->option('auth')) {
      $this->templateName = 'default';
    }

    $this->templatePath = dirname(__FILE__) . "/../Templates/Controllers/{$path}{$this->templateName}$this->templateExtention";

    return TRUE;
  }

  /**
   * Prepare the requestStore's data.
   *
   * @return boolean|string
   */
  protected function requestStore()
  {
    $requestStoreName = "{$this->controllerNameUpperFirst}StoreRequest";
    $requestStorePath = base_path("app/Http/Requests/$requestStoreName.php");

    if (! AdaFile::exists($requestStorePath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tRequestStore '$requestStoreName' not exists!\n\tPath: $requestStorePath");
      return FALSE;
    }

    $this->tagUse .= "use App\\Http\\Requests\\$this->guardName\\$requestStoreName;\n";

    return$requestStoreName;
  }

  /**
   * Prepare the requestUpdate's data.
   *
   * @return boolean|string
   */
  protected function requestUpdate() {
    $requestUpdateName = "{$this->controllerNameUpperFirst}UpdateRequest";
    $requestUpdatePath = base_path("app/Http/Requests/$requestUpdateName.php");

    if (! AdaFile::exists($requestUpdatePath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tRequestUpdate '$requestUpdateName' not exists!\n\tPath: $requestUpdatePath");
      return FALSE;
    }

    $this->tagUse .= "use App\\Http\\Requests\\$this->guardName\$requestUpdateName;\n";

    return $requestUpdateName;
  }

  /**
   * Add a route in route file for the guard and group's middleware choose.
   *
   * @return bool
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  protected function updateRouteController()
  {
    $group = ucfirst($this->middlewareGroupName);
    $name = str_singular($this->guardNameUpperFirst);
    $routeFilePath = base_path("routes/{$group}{$name}.php");

    if ($this->middlewareGroupName == 'api') {
      $route = "Route::post('$this->controllerName', ['as' => '$this->controllerName.get', 'uses' => 'Api\\$this->guardNameUpperFirst\\$this->controllerClassName@get']);\n";
      $route .= "Route::post('$this->controllerName/store', ['as' => '$this->controllerName.store', 'uses' => 'Api\\$this->guardNameUpperFirst\\$this->controllerClassName@store']);\n";
      $route .= "Route::post('$this->controllerName/update/{id}', ['as' => '$this->controllerName.update', 'uses' => 'Api\\$this->guardNameUpperFirst\\$this->controllerClassName@update']);\n\n$this->TAG_ROUTE";
    }
    else {
      // Initialize the content route file.
      $route = "Route::get('$this->controllerName', ['as' => '$this->controllerName.index', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@index']);\n";

      // Add route to the base guard si controllerName is 'welcome'.
      if ($this->controllerName == "welcome") {
        $route .= "Route::get('/', ['as' => '$this->controllerName.index', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@index']);\n";
      }

      // Add route.
      if ($this->option('viewAll')) {
        $route .= "Route::get('$this->controllerName/create', ['as' => '$this->controllerName.create', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@create']);\n";
        $route .= "Route::post('$this->controllerName/store', ['as' => '$this->controllerName.store', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@store']);\n";
        $route .= "Route::get('$this->controllerName/edit/{id}', ['as' => '$this->controllerName.edit', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@edit']);\n";
        $route .= "Route::post('$this->controllerName/update/{id}', ['as' => '$this->controllerName.update', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@update']);\n\n$this->TAG_ROUTE";
      }
      else {
        $route .= "Route::post('$this->controllerName/store', ['as' => '$this->controllerName.store', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@store']);\n";
        $route .= "Route::post('$this->controllerName/update/{id}', ['as' => '$this->controllerName.update', 'uses' => '$this->guardNameUpperFirst\\$this->controllerClassName@update']);\n\n$this->TAG_ROUTE";
      }
    }

    // Get content route file and update content.
    $content = AdaFile::get($routeFilePath);
    $content = str_replace("/*TAG_ROUTE*/", $route, $content);

    // Update route file.
    AdaFile::put($routeFilePath, $content);

    // Display success.
    $this->info("\nRoute file updated.\nPath: $routeFilePath");

    return TRUE;
  }

  /**
   * Make a view(s) for the controller's method.
   *
   * @return boolean
   */
  protected function makeView()
  {
    if ($this->option('viewAll')) {
      $views = ['index', 'create','edit'];

      foreach ($views as $view) {
        if (! $this->callCommandMakeView($view, $this->viewExtend)) return FALSE;
      }
    }
    elseif($this->option('auth')) {
      $templatesSass = [
        'Login' => 'Login/index',
      ];

      $templates = [
        'Login' => 'Login/index',
        'Register' => 'Register/index',
        'ForgotPassword' => 'ForgotPassword/index',
        'ResetPassword' => 'ResetPassword/index',
      ];

      if (! $this->callCommandMakeView(
        'index',
        $this->viewExtend,
        Arr::get($templates, $this->name),
        Arr::get($templatesSass, $this->name))
      ) return FALSE;
    }
    else {
      if (! $this->callCommandMakeView('index', $this->viewExtend)) return FALSE;
    }

    return TRUE;
  }

  /**
   * Call the view's make command.
   *
   * @param string $name
   * @param string $viewExtend
   *
   * @return bool
   */
  protected function callCommandMakeView($name, $viewExtend, $template = NULL, $templateSass = NULL)
  {
    $process = new Process("php adn make:view $this->controllerName.$name --guard=$this->guardName --extend=$viewExtend --template=$template --templateSass=$templateSass");
    $process->run();
    echo $process->getOutput();
    if (! $process->isSuccessful()) return FALSE;

    return TRUE;
  }

  /**
   *
   */
  protected function makeBaseGuard()
  {
    /*
     * Create Controller Syndicate.
     */
    $controllerPath = base_path("app/Http/ControllersSyndicate/$this->guardNameUpperFirst/Controller.php");

    $content = AdaFile::get( dirname(__FILE__) . "/../Templates/ControllersSyndicate/Controller.php" );
    $content = str_replace("TAG_GUARD_NAME_UCFIRST", $this->guardNameUpperFirst, $content);
    $content = str_replace("TAG_GUARD_NAME", $this->guardName, $content);

    AdaFile::makeDir(dirname($controllerPath));
    AdaFile::put($controllerPath, $content);

    // Display success.
    $this->info("\nController base created.\nPath: $controllerPath");

    /*
     * Create Controller Interface.
     */
    $controllerPath = "$this->guardDirPath/AuthInterface.php";

    $content = AdaFile::get( dirname(__FILE__) . "/../Templates/Controllers/AuthInterface.php" );
    $content = str_replace("TAG_NAMESPACE_NAME", $this->controllerNamespace, $content);
    $content = str_replace("TAG_GUARD_NAME", $this->guardName, $content);

    AdaFile::makeDir(dirname($controllerPath));
    AdaFile::put($controllerPath, $content);

    // Display success.
    $this->info("\nController's interface AuthInterface created.\nPath: $controllerPath");

    /*
     * Create Controller Base.
     */
    $controllerPath = "$this->guardDirPath/Controller.php";

    $content = AdaFile::get( dirname(__FILE__) . "/../Templates/Controllers/Controller.php" );
    $content = str_replace("TAG_NAMESPACE_NAME", $this->controllerNamespace, $content);
    $content = str_replace("TAG_GUARD_NAME_UCFIRST", $this->guardNameUpperFirst, $content);

    AdaFile::makeDir(dirname($controllerPath));
    AdaFile::put($controllerPath, $content);

    // Display success.
    $this->info("\nController Base created.\nPath: $controllerPath");

    return TRUE;
  }
}
