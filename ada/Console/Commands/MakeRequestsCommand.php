<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;
use AdaConsole;

class MakeRequestsCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:request
                          {name : Request's name.}
                          {--template=  : Template used.}
                          {--guard= : Define the application guard ('guest', 'frontuser', 'backuser', 'admin', or 'master'), by default 'guest' is used.}
                          {--model= : Define model's resources reference.}
                          {--data : Specifie if use data in config/consoleData.php}
                          {--norequired : Disable required rule.}";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a request in /app/Http/Requests/*';

  /**
   * Argument 'name';
   *
   * @var string
   */
  protected $name;

  /**
   * Option 'template';
   *
   * @var string
   */
  protected $template;

  /**
   * Option 'guard';
   *
   * @var string
   */
  protected $guard;

  /**
   * Option 'model;
   *
   * @var string
   */
  protected $model;

  /**
   * Request's name.
   *
   * @var string
   */
  protected $requestName;

  /**
   * Request's full path.
   *
   * @var string
   */
  protected $requestPath;

  /**
   * Request class's name.
   *
   * @var string
   */
  protected $requestClassName;

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
   * Template extention.
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
   * Option model's name.
   *
   * @var string
   */
  protected $modelName;

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
   * @return mixed
   */
  public function handle()
  {
    $this->init($this->argument('name'), $this->option('template'), $this->option('guard'), $this->option('model'));

    if (! $this->name()) return;

    if (! $this->template()) return;

    if (! $this->guard()) return;

    if (! $this->model()) return;

    $this->requestPath = base_path("app/Http/Requests/". ucfirst($this->guardName) ."/$this->requestClassName.php");

    if (AdaFile::exists($this->requestPath))
    {
      $this->error("\n\t[ErrorAdaCommand]\n\tFile $this->requestClassName already exists!\n\tPath: $this->requestPath");
      return;
    }

    AdaFile::makeDir(dirname($this->requestPath));

    $namespace = $this->guard ? "App\\Http\\Requests\\" . ucfirst($this->guardName) : "App\\Http\\Requests";
    $rules = $this->requestRules();

    $content = AdaFile::get($this->templatePath);
    $content = str_replace("TAG_NAMESPACE_NAME", $namespace, $content);
    $content = str_replace("TAG_CLASS_NAME", $this->requestClassName, $content);
    $content = str_replace("/*TAG_RULES*/", $rules, $content);

    AdaFile::put($this->requestPath, $content);
    $this->info("\nRequest {$this->requestClassName} created.\nPath: {$this->requestPath}");
  }

  /**
   * Initialization the console command arguments and options.
   *
   * @param string $name
   * @param string $template
   * @param string $guard
   *
   * @return void
   */
  private function init($name, $template, $guard, $model) {
    $this->name = $name;

    $this->template = $template;

    $this->guard = $guard;

    $this->model = $model;
  }

  /**
   * Set the request's name and class's name.
   *
   * @return boolean
   */
  private function name() {
    $this->requestName = AdaConsole::purgeStrWithMaj($this->name, ['requests', 'request']);

    if ($this->requestName == "") {
      $this->error("\n\t[ErrorAdaCommand]\n\tName {$this->name} is not valid !\n\tNot accepted:\n\t\trequest\n\t\trequests");
      return FALSE;
    }

    $this->requestClassName = $this->requestName . "Request";

    return TRUE;
  }

  /**
   * Set the template's name and path.
   *
   * @param string $path
   *
   * @return bool
   */
  private function template($path = '') {
    if ($path != '') {
      // Normalize the directory separator.
      $path = AdaFile::normalizePath($path);

      // Clean the path beginning.
      $path = str_start_clear($path, ['/', '\\', '.']);

      // Add a slash to end the path if he does not have one.
      $path = str_finish($path, '/');
    }

    // If the template is null, $templateName will take the value 'default'.
    if (! $this->templateName = $this->template) {
      $this->templateName = 'default';
    }

    $this->templatePath = dirname(__FILE__) . "/../Templates/Requests/{$path}{$this->templateName}$this->templateExtention";

    return TRUE;
  }

  /**
   * Set the guard's name,
   *
   * @return boolean
   */
  private function guard()
  {
    if (! $this->guardName = $this->guard) {
      $this->guardName = NULL;
    }

    return TRUE;
  }

  /**
   * Set the model's data.
   *
   * @return boolean
   */
  private function model()
  {
    if ($this->modelName = $this->model) {
      $this->modelName = str_singular(ucfirst($this->modelName));
    }
    else if ($this->option('data')) {
      $this->modelName = ucfirst(str_singular(snake_case($this->requestName)));
    }

    return TRUE;
  }

  /**
   * Return the request's rules if a model is define.
   *
   * @return boolean
   */
  private function requestRules()
  {
    if ($this->modelName) {
      if ($model = AdaConsole::buildClassByString("App/Models/$this->modelName")) {
        $rules = "";

        foreach ($model->getFillable() as $key) {
          if ($this->option('norequired')) {
            $rules .= "'{$key}' => '',\n\t\t\t";
          }
          else {
            $rules .= "'{$key}' => 'required',\n\t\t\t";
          }
        }
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tModel $this->modelName not exists!\n\tPath: app/Models/$this->modelName.php");
        return FALSE;
      }
    }
    else {
      $rules = "//'name' => 'required|min:3|max:255'";
    }

    return $rules;
  }
}
