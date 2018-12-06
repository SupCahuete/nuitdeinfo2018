<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;

use Ada\Assistants\ConsoleAssistant;

class MakeMiddlewareCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:middleware
                          {name : Middleware's name.}
                          {--guard= : Guard's name.}
                          {--template= : Template used.}
                          {--route= : Middleware's route in app/Http/Kernel.php}";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a middleware in app/Http/Middleware/*';

  /**
   * ConsoleAssistant.
   *
   * @var ConsoleAssistant
   */
  protected $consoleAssistant;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $this->consoleAssistant = new ConsoleAssistant();
  }

  /**
   * Execute the console command.
   *
   * @return bool
   */
  public function handle()
  {
    $middlewareClassName = $this->consoleAssistant->purgeStrWithMaj($this->argument('name'), [
      'middleware', 'middlewares', 'middle',
    ]);

    if ($templateName = $this->option('template')) {
      $templateName = $this->consoleAssistant->purgeStrWithMaj($templateName);
    }
    else {
      $templateName = "default";
    }

    /*
     * Prepare content file.
     */
    $content = AdaFile::get(dirname(__FILE__) . "/../Templates/Middleware/$templateName.php");

    if ($guardName = $this->option('guard')) { // If a guard exist.
      $guardNameUpperFirst = $this->consoleAssistant->purgeStrWithMaj($guardName);
      $guardName = lcfirst($guardNameUpperFirst);

      $middlewareDirectoryPath = "app/Http/Middleware/$guardNameUpperFirst";
      $middlewarePath = base_path("$middlewareDirectoryPath/$middlewareClassName.php");
      $middlewareNamespaceName = str_replace("/", "\\", $middlewareDirectoryPath);

      if (AdaFile::exists($middlewarePath)) {
        $this->warn("\n\t[WarningAdaCommand]\n\tFile {$middlewareClassName} already exists!\n\tPath: {$middlewarePath}");
        return TRUE;
      }

      /*
       * Create guard's directory.
       */
      AdaFile::makeDir(dirname($middlewarePath), 0755);

      /*
       * Prepare content file.
       */
      $content = str_replace("TAG_NAMESPACE_NAME", $middlewareNamespaceName, $content);
      $content = str_replace("TAG_GUARD_NAME", $guardName, $content);

      /*
       * Update routeMiddleware.
       */
      $this->updateHttpKernel($middlewareClassName, $guardName);
    }
    else { // If a guard not exist.
      $middlewarePath = base_path("app/Http/Middleware/{$middlewareClassName}.php");

      if (AdaFile::exists($middlewarePath)) {
        $this->warn("\n\t[WarningAdaCommand]\n\tFile {$middlewareClassName} already exists!\n\tPath: {$middlewarePath}");
        return TRUE;
      }

      /*
       * Update routeMiddleware.
       */
      $this->updateHttpKernel($middlewareClassName);
    }

    /*
     * Prepare content file.
     */
    $content = str_replace("TAG_CLASS_NAME", $middlewareClassName, $content);

    /*
     * Create file.
     */
    AdaFile::put($middlewarePath, $content);
    $this->info("\nMiddleware {$middlewareClassName} created.\nPath: {$middlewarePath}");

    return FALSE;
  }

  /**
   * Update routeMiddleware in app/Http/Kernel.php.
   *
   * @param string $middlewareName
   * @param string $guardName
   *
   * @return mixed
   */
  private function updateHttpKernel($middlewareName, $guardName = NULL) {
    $httpKernelPath = base_path("app/Http/Kernel.php");

    $guardNameUpperFirst = ucfirst($guardName);

    $middlewareNameLowerFirst = lcfirst($middlewareName);
    $middlewareNameUpperFirst = ucfirst($middlewareName);

    if ($guardName) {
      /*
       * update TAG_ROUTE.
       */
      $routeMiddlesware = $this->option('route') ?? 'auth';
      $tagMiddleware = "/*TAG_MIDDLEWARE_AUTH*/";
      $TAG_MIDDLEWARE = "'$guardName.$routeMiddlesware' => Middleware\\$guardNameUpperFirst\\$middlewareNameUpperFirst::class,\n";
      $TAG_MIDDLEWARE .= "\t\t\t$tagMiddleware";
    }
    else {
      /*
       * update TAG_ROUTE.
       */
      $routeMiddlesware = $this->option('route') ?? $middlewareNameLowerFirst;
      $tagMiddleware = "/*TAG_MIDDLEWARE*/";
      $TAG_MIDDLEWARE = "'$routeMiddlesware' => Middleware\\$middlewareNameUpperFirst::class,\n";
      $TAG_MIDDLEWARE .= "\t\t\t$tagMiddleware";
    }

    /*
     * Prepare content file.
     */
    $content = AdaFile::get($httpKernelPath);
    $content = str_replace($tagMiddleware, $TAG_MIDDLEWARE, $content);

    /*
     * Create file.
     */
    AdaFile::put($httpKernelPath, $content);
    $this->info("\nHttp Kernel updated.\nPath: $httpKernelPath");
  }
}
