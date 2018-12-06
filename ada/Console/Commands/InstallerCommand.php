<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;

class InstallerCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "install {name : Install's name.}";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Installer';

  /**
   * The install's name.
   *
   * @var string
   */
  protected $name;

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
    $this->init();

    if (in_array( strtolower($this->name), ['googlemaps', 'maps']) ) {
      $this->installGoogleMaps();
    }
    elseif (in_array( strtolower($this->name), ['materialize', 'mat']) ) {
      $this->installMaterialize();
    }
    elseif (in_array( strtolower($this->name), ['godfather', 'monitor']) ) {
      $this->installGodfather();
      $this->warn('Launch a "composer update" for finish installation.');
    }
    else {
      $this->warn('Not found.');
      return NULL;
    }

    $this->info('Success installation !');
  }

  /**
   * Init.
   *
   * @return void
   */
  protected function init() {
    $this->name = $this->argument('name');
  }

  /**
   * Install Google Maps dependences.
   *
   * @return void
   */
  protected function installGoogleMaps() {
    shell_exec('composer require alexpechkarev/google-maps:1.0.8');
  }

  /**
   * Install Google Maps dependences.
   *
   * @return void
   */
  protected function installMaterialize() {
    $vendorPath = base_path('ada/Console/vendor/materialize');

    // Copy CSS.
    copy("$vendorPath/css/materialize.min.css", asset_path_css('materialize.min.css'));

    // Copy JS.
    copy("$vendorPath/js/materialize.min.js", asset_path_js('materialize.min.js'));
  }

  /**
   * Install Godfather monitor.
   *
   * File modifier
   *
   * @return void
   */
  protected function installGodfather() {
    // Add key to composer.
    $this->composerAdd('require', ["spatie/laravel-server-monitor" => "1.3.1"]);

    // Update builder.
    $pathBuilder = base_path("ada/builder/builder.php");
    $content = file_get_contents($pathBuilder);
    $content = str_replace('//"spatie/laravel-server-monitor/src/Models/Concerns/HasProcess.php",', '"spatie/laravel-server-monitor/src/Models/Concerns/HasProcess.php",', $content);
    $content = str_replace('//"spatie/laravel-server-monitor/src/Commands/AddHost.php",', '"spatie/laravel-server-monitor/src/Commands/AddHost.php",', $content);
    file_put_contents($pathBuilder, $content);

    // Add server-monitor in config folder.
    copy(
      base_path("ada/builder/config/server-monitor.php"),
      base_path("config/server-monitor.php")
    );

    // Add hosts table migration.
    copy(
      base_path("ada/builder/database/migrations/2018_01_01_0000000_create_hosts_table.php"),
      base_path("database/migrations/2018_01_01_0000000_create_hosts_table.php")
    );

    // Add checks table migration.
    copy(
      base_path("ada/builder/database/migrations/2018_01_01_0010000_create_checks_table.php"),
      base_path("database/migrations/2018_01_01_0010000_create_checks_table.php")
    );
  }

  /**
   * Add keys to composer.json
   *
   * @param $target
   * @param array $adds
   */
  protected function composerAdd($target, array $adds) {
    $composerPath = base_path("composer.json");

    $content = json_decode( file_get_contents($composerPath), TRUE );

    $content[$target] = array_merge($content[$target], $adds);

    file_put_contents($composerPath, json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  }
}
