<?php

namespace Ada\Console;

use Ada\Console\Commands\CompilerSassCommand;
use Ada\Console\Commands\CompilerViewsCommand;
use Ada\Console\Commands\InstallerCommand;
use Ada\Console\Commands\MakeMigrationCommand;
use Ada\Console\Commands\MakeSassCommand;
use Ada\Console\Commands\TesterCommand;
use Ada\Console\Commands\TranslateCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Ada\Console\Commands\BloodlineCommand;
use Ada\Console\Commands\MakeCommandCommand;
use Ada\Console\Commands\MakeControllerCommand;
use Ada\Console\Commands\MakeFacadeCommand;
use Ada\Console\Commands\MakeGuardCommand;
use Ada\Console\Commands\MakeMiddlewareCommand;
use Ada\Console\Commands\MakeModelCommand;
use Ada\Console\Commands\MakeRequestsCommand;
use Ada\Console\Commands\MakeSeederCommand;
use Ada\Console\Commands\MakeViewCommand;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    // Main Commands
    InstallerCommand::class,
    CompilerSassCommand::class,
    CompilerViewsCommand::class,
    BloodlineCommand::class,

    // Building commands.
    MakeCommandCommand::class,
    MakeControllerCommand::class,
    MakeFacadeCommand::class,
    MakeGuardCommand::class,
    MakeMiddlewareCommand::class,
    MakeMigrationCommand::class,
    MakeModelCommand::class,
    MakeRequestsCommand::class,
    MakeSeederCommand::class,
    MakeViewCommand::class,
    MakeSassCommand::class,

    // Tester commands
    TesterCommand::class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // $schedule->command('inspire')
    //          ->hourly();
  }

  /**
   * Register the Closure based commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    require base_path('routes/console.php');
  }
}
