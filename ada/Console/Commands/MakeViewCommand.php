<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\NullLogger;
use Symfony\Component\Process\Process;
use Artisan;
use AdaFile;
use AdaConsole;



class MakeViewCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:view 
                            {name : The view's name (or guard's name if layouts's option used).}
                            {--template=  : Template used.}
                            {--guard= : Define the application guard ('guest', 'frontuser', 'backuser', 'admin', or 'master'), by default 'guest' is used.}
                            {--extend=  : For used default layouts template (main, menu, email), by default 'main' is used.}
                            {--layouts  : Used for create only the layouts}
                            {--templateSass=  : Sass template used.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a view in /resources/views/*';

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
   * Option 'extend';
   *
   * @var string
   */
  protected $extend;

  /**
   * View's template path.
   *
   * @var string
   */
  protected $templateSass;

  /**
   * View's name.
   *
   * @var string
   */
  protected $viewName;

  /**
   * View's full path.
   *
   * @var string
   */
  protected $viewPath;

  /**
   * Sass's path.
   *
   * @var string
   */
  protected $sassName;

  /**
   * Css's path.
   *
   * @var string
   */
  protected $cssPath;

  /**
   * Controller's name with upper case on first letter.
   *
   * @var string
   */
  protected $viewTitle;

  /**
   * View's template name.
   *
   * @var string
   */
  protected $templateName;

  /**
   * View's template name.
   *
   * @var string
   */
  protected $templatePath;

  /**
   * View's template extention.
   *
   * @var string
   */
  protected $templateExtention = ".blade.php";

  /**
   * Guard's name.
   *
   * @var string
   */
  protected $guardName;

  /**
   * Guard's name.
   *
   * @var string
   */
  protected $guardNameUpperFirst;

  /**
   * Guard view path.
   *
   * @var string
   */
  protected $guardDirViewPath;

  /**
   * Layout extend's name.
   *
   * @var string
   */
  protected $layoutExtend;

  /**
   * Lang's Folder of developpement.
   *
   * @var string
   */
  protected $langdev = 'lang-dev';

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
   * @return void
   */
  public function handle()
  {
    if ($this->option('layouts')) {
      $layouts = ['main', 'menu', 'email'];

      if (! $guard = $this->option('guard')) {
        $guard = AdaFile::normalizePath($this->argument('name'));
        $guard = AdaConsole::purgeStrWithMaj($guard);
        $guard = lcfirst($guard);
      }

      foreach ($layouts as $layout) {
        $this->init(
          "layouts.$layout",
          "layouts/$layout",
          $guard
        );

        if (! $this->createView()) return;
      }
    }
    else {
      $this->init(
        $this->argument('name'),
        $this->option('template'),
        $this->option('guard'),
        $this->option('extend'),
        $this->option('templateSass')
      );

      if (! $this->createView()) return;
    }
  }

  /**
   * Initialization the console command arguments and options.
   *
   * @param string $name
   * @param string $template
   * @param string $guard
   * @param string $extend
   *
   * @return void
   */
  private function init($name, $template, $guard, $extend = NULL, $templateSass = NULL) {
    $this->name = $name;

    $this->template = $template;

    $this->guard = $guard;

    $this->extend = $extend;

    $this->templateSass = $templateSass;
  }

  /**
   * Create a view.
   *
   * @return boolean
   */
  private function createView() {
    if (! $this->view()) return FALSE;

    if (! $this->template()) return FALSE;

    // Create the directory for the layout view.
    if ($this->option('layouts')) {
      @mkdir(dirname($this->viewPath), 0755, TRUE);
    }
    elseif (! AdaFile::exists($this->guardDirViewPath)) { // Create the guard's directory for the view.
      if (AdaFile::makeDir($this->guardDirViewPath, 0755)) {

        $this->makeLangGuard();

        // Invoke new process for make the layouts views.
        $process = new Process("php adn make:view NULL --layouts --guard=$this->guardName");
        $process->run();
        echo $process->getOutput();
        if (! $process->isSuccessful()) return FALSE;

        AdaFile::makeDir(dirname($this->viewPath), 0755);
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tNot create directory '$this->guardDirViewPath'.");
        return FALSE;
      }
    }
    else { // Create the directory for the view.
      AdaFile::makeDir(dirname($this->viewPath), 0755);
    }

    if (! $this->option('layouts') and ! $this->layoutExtend()) {return FALSE;}

    $content = AdaFile::get($this->templatePath);
    $content = str_replace("TAG_GUARD_NAME_LCFIRST", lcfirst($this->guardName), $content);
    $content = str_replace("TAG_GUARD_NAME", $this->guardName, $content);
    $content = str_replace("TAG_VIEW_NAME_LCFIRST", lcfirst($this->viewTitle), $content);
    $content = str_replace("TAG_VIEW_NAME_UCFIRST", ucfirst($this->viewTitle), $content);
    $content = str_replace("TAG_VIEW_NAME", $this->viewTitle, $content);
    $content = str_replace("TAG_CSS_PATH", $this->cssPath, $content);
    $content = str_replace("TAG_EXTENDS", "$this->guardName.layouts.$this->layoutExtend", $content);


    // Create view file.
    AdaFile::put($this->viewPath, $content);
    $this->info("\nView {$this->viewName} created.\nPath: {$this->viewPath}");

    if (! $this->option('layouts'))
    {
      $template = $this->templateSass;

      if (! $this->makeSass($this->sassName, $template)) return FALSE;
    }

    return TRUE;
  }

  /**
   * Set 'viewName' and 'viewPath'.
   *
   * @return boolean
   */
  private function view()
  {
    // Prepare the guard.
    $this->guard();

    $view = lcfirst(AdaConsole::purgeStrWithMaj($this->name, ['.blade', 'blade']));

    if ($this->option('layouts')) {
      $view = lcfirst($view);
      $view = AdaFile::normalizePath($view);
    }
    else {
      $this->sassName = $view;

      $view = AdaFile::normalizePath($view);

      // create css's path for make url asset.
      $this->cssPath = strtolower("$this->guardName/$view.css");
    }

    $this->viewName = lcfirst(basename($view));

    // html title
    $this->viewTitle = ucfirst(dirname($view));

    $this->guardNameUpperFirst = lcfirst($this->guardName);

    $this->guardDirViewPath = resource_path("views/{$this->langdev}/$this->guardNameUpperFirst");

    $viewPath = str_contains($view, '/') ? dirname($view).'/' : '';

    $this->viewPath = $this->guardDirViewPath . "/$viewPath{$this->viewName}$this->templateExtention";

    if (AdaFile::exists($this->viewPath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tFile {$this->viewName} already exists!\n\tPath: {$this->viewPath}");
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Initialize 'templateName' and 'templatePath'.
   *
   * @return boolean
   */
  private function template()
  {
    if (! $this->templateName = $this->template) {
      $this->templateName = "default";
    }

    $this->templatePath = dirname(__FILE__) . "/../Templates/Views/{$this->templateName}$this->templateExtention";

    if (! AdaFile::exists($this->templatePath)) {
      $this->error("\n\t[ErrorAdaCommand]\n\tTemplate {$this->templateName} not exists!\n\tPath: $this->templatePath");
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Initialize 'guardName'.
   *
   * @return boolean
   */
  private function guard()
  {
    if (! $this->guardName = $this->guard) {
     $this->guardName = "guest";
    }

    return TRUE;
  }

  /**
   * Initialize 'layoutExtend'.
   *
   * @return boolean
   */
  private function layoutExtend()
  {
    if (! $this->layoutExtend = $this->extend) {
      $this->layoutExtend = "main";
    }

    return TRUE;
  }

  /*
   * Make the lang translat file for the guard.
   */
  private function makeLangGuard() {
    $templatePath = dirname(__FILE__) . "/../Templates/Lang/default-guard.php";

    $content = AdaFile::get($templatePath);
    $content = str_replace("TAG_GUARD_NAME_UCFIRST", ucfirst($this->guardName), $content);

    // Create Lang files.
    foreach (AdaFile::directories(resource_path("lang")) as $directory) {
      $langFullPath = "$directory/$this->guardName.php";
      $directory =  basename($directory);

      if ( ! AdaFile::exists($langFullPath)) {
        AdaFile::put($langFullPath, $content);
        $this->info("\nLang $directory/$this->guardName created.\nPath: {$langFullPath}");
      }
    }
  }

  /**
   * Call command for make a view.
   *
   * @param string $name
   * @param string $template
   *
   * @return boolean
   */
  private function makeSass($name, $template = NULL) {
    // Invoke new process for make the sass file.
    $process = new Process("php adn make:sass $name --guard=$this->guardName --template=$template");
    $process->run();

    echo $output = $process->getOutput();
    if (! $process->isSuccessful() or str_contains($output, "[ErrorAdaCommand]")) return FALSE;

    return TRUE;
  }
}
