<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;


class MakeFacadeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:facade
                             {name : Facade's name.}
                             {--template= : Template used.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Make a Ada facade.';

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
    $this->info('Coming Soon');
  }
}
