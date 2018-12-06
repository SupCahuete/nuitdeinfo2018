<?php

/*
  |--------------------------------------------------------------------------
  | Builder Ada
  |--------------------------------------------------------------------------
  |
  | //
  */


/* * * * * * * * * * * * * * * * * *
 *         Call builder.         *
 * * * * * * * * * * * * * * * * * */
new BuilderAda();


/**
 * Class BuilderAda
 */
Class BuilderAda {

  /**
   * Production's parameters.
   *
   * @var array
   */
  protected $production = [
    'user' => '',
    'group' => 'www-data',
  ];

  /**
   * Developpement's parameters.
   *
   * @var array
   */
  protected $dev = [
    'user' => '',
    'group' => 'www-data',
  ];

  /**
   * Parameters used.
   *
   * @var array
   */
  protected $env;

  /**
   * In production or others mode.
   *
   * @var boolean
   */
  protected $prod = TRUE;

  /**
   * //
   *
   * @var bool|string
   */
  protected $base_path;

  /**
   * String's output display.
   *
   * @var string
   */
  protected $output = "";

  /**
   * //
   *
   * @var string
   */
  protected $builderDir;

  /**
   * Laravel absolute path
   *
   * @var string
   */
  protected $laravelPath;

  /**
   * List of the vendor file update.
   *
   * @var array
   */
  protected $pathVendor = [
    /*
     * Monitoring
     */
    //"spatie/laravel-server-monitor/src/Commands/AddHost.php",
    //"spatie/laravel-server-monitor/src/Models/Concerns/HasProcess.php",

    "laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php",
    "laravel/framework/src/Illuminate/Support/Debug/Dumper.php",
    "laravel/framework/src/Illuminate/Auth/TokenGuard.php",
    "laravel/framework/src/Illuminate/View/Factory.php",
    //"laravel/cashier/src/Subscription.php",
    "nesbot/carbon/src/Carbon/Carbon.php",
    "symfony/debug/ExceptionHandler.php",
  ];

  /**
   * Bash foreground colors.
   *
   * @var array
   */
  protected $foreground_colors = [
    "black" => "0;30",
    "dark_gray" => "1;30",
    "blue" => "0;34",
    "light_blue" => "1;34",
    "green" => "0;32",
    "light_green" => "1;32",
    "cyan" => "0;36",
    "light_cyan" => "1;36",
    "red" => "38;5;160",
    "light_red" => "1;31",
    "purple" => "0;35",
    "light_purple" => "1;35",
    "brown" => "0;33",
    "yellow" => "1;93",
    "light_gray" => "0;37",
    "white" => "38;5;255",
    'orange' => '38;5;215',
  ];

  /**
   * Bash background colors.
   *
   * @var array
   */
  protected $background_colors = [
    "black" => "40",
    "red" => "41",
    "green" => "42",
    "yellow" => "43",
    "blue" => "44",
    "magenta" => "45",
    "cyan" => "46",
    "light_gray" => "47",
    "orange" => "48;5;221",
  ];

  /**
   * BuilderAda constructor.
   *
   * @return void
   */
  public function __construct()
  {
    $mode = $_SERVER['argc'] > 1 ? strtolower($_SERVER['argv'][1]) : NULL;

    // ENV
    if (in_array($mode, ['dev', 'local'])) {
      $this->env = $this->dev;
      $this->prod = FALSE;
    }
    else {
      $this->env = $this->production;
    }

    // Define base path app.
    $this->base_path = realpath(__DIR__ . '/../../');

    // Define the builder's base path.
    $this->builderDir = dirname(__FILE__);

    // Define the laravel's base path.
    $this->laravelPath = realpath("$this->builderDir/../../");

    // Call installation.
    $this->install();
  }

  /**
   * Install update ada (include vendor).
   * 
   * @return void
   */
  protected function install() {
    $this->installVendor();
    $this->installEnv();
    $this->compileSass();
    $this->owner();

    if ($this->prod) {
      $this->compileView();
    }
  }

  /**
   * //
   *
   * @return void
   */
  protected function installVendor() {
    foreach ($this->pathVendor as $path)
    {
      $targetPath = "$this->laravelPath/vendor/$path";

      if (! file_exists($targetPath)) return;

      $content = file_get_contents("$this->builderDir/vendor/$path");

      if (@file_put_contents($targetPath, $content)) {
        $this->info("Update vendor: $path");
      }
      else {
        $this->warn("\t[WarningAdaBuilder]\n\tAccess denied.\n\tDo not forget to call `composer update` for generate the laravel's vendor ;)");
      }
    }
  }

  /**
   * //
   *
   * @return void
   */
  protected function installEnv() {
    $envPath = "$this->laravelPath/.env";

    if (! file_exists($envPath)) {
      if (copy("$this->laravelPath/.env.example", $envPath)) {
        $this->info(shell_exec("php artisan key:generate"));
      }
      else {
        $this->warn("\t[ErrorAdaBuilder]\n\tAccess denied.\n\tOR '.env.example' not exists !");
      }
    }
  }

  /**
   * Launch the compiler sass command.
   *
   * @return void
   */
  protected function compileSass() {
    echo shell_exec("php adn compiler:sass");
  }

  /**
   * //
   *
   * @return void
   */
  protected function owner()
  {
    $commands = [
      "chown -R " . $this->env['user'] . ":" . $this->env['group'] . ' ' . $this->base_path,
      "chgrp -R " . $this->env['group'] . ' '  . "{$this->base_path}/storage {$this->base_path}/bootstrap/cache {$this->base_path}/public/assets",
      "chmod -R ug+rwx {$this->base_path}/storage {$this->base_path}/bootstrap/cache {$this->base_path}/public/assets",
    ];

    foreach ($commands as $command) {
      $this->info("Executed: \"$command\"");
      echo $this->execute($command);
    }
  }

  /**
   * Compile the view with translate
   *
   * @return void
   */
  protected function compileView() {
    $response = strtolower(readline("\nCompile views ? [Y/n] : "));

    if ($response == '' or $response == 'y') {
      echo $this->execute('php adn compiler:view');
    }
  }

  /**
   * //
   *
   * @param $command
   *
   * @return string
   */
  protected function execute($command) {
    return shell_exec($command);
  }

  /**
   * //
   *
   * @param $msg
   * @param string $start
   * @param string $end
   *
   * @return void
   */
  protected function info($msg, $start = "", $end = "\n") {
    echo $this->getColoredString("$start{$msg}$end", 'light_green');
  }

  /**
   * //
   *
   * @param $msg
   * @param string $start
   * @param string $end
   *
   * @return void
   */
  protected function warn($msg, $start = "", $end = "\n\n") {
    echo $start . $this->getColoredString("\n\n$msg\n", 'red', 'orange') . $end;
  }

  /**
   * Returns colored string
   *
   * @param string $string
   * @param string|null $foreground_color
   * @param string|null $background_color
   *
   * @return string
   */
  protected function getColoredString($str, $foreground_color = null, $background_color = null) {
    $colored_string = "";

    // Check if given foreground color found
    if (isset($this->foreground_colors[$foreground_color])) {
      $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
    }

    // Check if given background color found
    if (isset($this->background_colors[$background_color])) {
      $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
    }

    return "$colored_string$str\033[0m";
  }
}
