<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;

use AdaConsole;

class BloodlineCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:bloodline
                            {name : Default's name for all creations.}
                            {--guard= : Define the application guard ('frontuser', 'backuser', 'admin' or 'master'), by default 'user' is used.}
                            {--group= : Group middleware (Supported: web or api), by default 'web' is used.}
                            {--norequired : Disable required rule.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Bloodline is a command for the all ressources creation (Migration, Seeder, Model, Requests, Guard, Middleware, ,View, Route, Controller).";

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
    $bloodlineName = AdaConsole::purgeStrWithMaj($this->argument('name'), [
      'table', 'create', 'table', 'seeder', 'seeds', 'seed', 'requests', 'request', 'table', 'create',
    ]);

    if ($bloodlineName == "") { $this->error("\n\t[ErrorAdaCommand]\n\tInvalid name."); return; }

    $bloodlineNamePlurial = str_plural($bloodlineName);

    /*
     * Make migration.
     */
    $this->call('make:migration', [
      'name' => $bloodlineNamePlurial,
      '--data' => TRUE,
    ]);

    /*
     * Make seeder.
     */
    $this->call('make:seeder', [
      'name' => $bloodlineNamePlurial,
      '--data' => TRUE,
    ]);

    /*
     * Make model.
     */
    $this->call('make:model', [
      'name' => $bloodlineName,
      '--data' => TRUE,
    ]);

    /*
     * Make request store.
     */
    $this->call('make:request', [
      'name' => $bloodlineNamePlurial.'Store',
      '--model' => $bloodlineName,
      '--guard' => $this->option('guard'),
      '--norequired' => $this->option('norequired'),
    ]);

    /*
     * Make request update.
     */
    $this->call('make:request', [
      'name' => $bloodlineNamePlurial.'Update',
      '--model' => $bloodlineName,
      '--guard' => $this->option('guard'),
      '--norequired' => TRUE,
    ]);

    /*
     * Make controller.
     */
    $this->call('make:controller', [
      'name' => $bloodlineNamePlurial,
      '--data' => TRUE,
      '--guard' => $this->option('guard'),
    ]);

    /*
     * Make view.
     */
    $this->call('make:view', ['name' => "$bloodlineNamePlurial.index"]);
  }
}
