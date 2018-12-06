<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use AdaFile;
use AdaConsole;



class MakeSassCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = <<< EOF
make:sass
{name : The sass's name (or guard's name if layouts's option used).}
{--template=  : Template used.}
{--guard= : Define the application guard ('guest', 'frontuser', 'backuser', 'admin', or 'master'), by default 'guest' is used.}
EOF;

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a sass in /resources/assets/sass/*';

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
   * Sass's name.
   *
   * @var string
   */
  protected $sassName;

  /**
   * Sass's full path.
   *
   * @var string
   */
  protected $sassPath;

  /**
   * Sass's template name.
   *
   * @var string
   */
  protected $templateName;

  /**
   * Sass's template path.
   *
   * @var string
   */
  protected $templatePath;

  /**
   * Sass's template extention.
   *
   * @var string
   */
  protected $templateExtention = ".scss";

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
   * Guard sass path.
   *
   * @var string
   */
  protected $guardDirSassPath;

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
    $this->init(
      $this->argument('name'),
      $this->option('template'),
      $this->option('guard')
    );

    if (! $this->createSass()) return;
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
  private function init($name, $template, $guard) {
    $this->name = $name;

    $this->template = $template;

    $this->guard = $guard;
  }

  /**
   * Create a sass.
   *
   * @return boolean
   */
  private function createSass() {
    if (! $this->guard()) return FALSE;

    if (! $this->sass()) return FALSE;

    if (! $this->template()) return FALSE;

    // Create the directory for the sass.
    if (! AdaFile::exists($this->guardDirSassPath)) {
      if (AdaFile::makeDir($this->guardDirSassPath, 0755)) { // Create the guard's directory for the sass.

        // Invoke new process for make the layouts sass.
        foreach (['_variables', 'main'] as $layout) {
          $process = new Process("php adn make:sass $layout --guard=$this->guardName --template=$layout");
          $process->run();
          echo $process->getOutput();
          if (! $process->isSuccessful()) return FALSE;
        }

      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tNot create directory '$this->guardDirSassPath'.");
        return FALSE;
      }
    }

    // Create the directory for the sass.
    if (! AdaFile::exists(dirname($this->sassPath))) {
      AdaFile::makeDir(dirname($this->sassPath), 0755);
    }

    $content = AdaFile::get($this->templatePath);

    AdaFile::put($this->sassPath, $content);
    $this->info("\nSass {$this->sassName} created.\nPath: {$this->sassPath}");

    return TRUE;
  }

  /**
   * Set 'sassName' and 'sassPath'.
   *
   * @return boolean
   */
  private function sass()
  {
    $sass = AdaConsole::purgeStrWithMaj($this->name, ['.sass', 'sass', '.scss', 'scss']);

    $sass = AdaFile::normalizePath($sass);

    $this->sassName = lcfirst(basename($sass));

    $this->guardNameUpperFirst = ucfirst($this->guardName);

    $this->guardDirSassPath = resource_path("assets/sass/$this->guardNameUpperFirst");

    $sassPath = str_contains($sass, '/') ? dirname($sass).'/' : '';

    $this->sassPath = $this->guardDirSassPath . "/$sassPath{$this->sassName}$this->templateExtention";

    if (AdaFile::exists($this->sassPath)) {
      $this->warn("\n\t[WarningAdaCommand]\n\tFile {$this->sassName} already exists!\n\tPath: {$this->sassPath}");
      exit();
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

    $this->templatePath = dirname(__FILE__) . "/../Templates/Sass/{$this->templateName}$this->templateExtention";

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
}
