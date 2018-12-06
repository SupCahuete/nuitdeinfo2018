<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;

class CompilerSassCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "compiler:sass";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '';

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
    $cssPath = public_path("assets/css");

    (new \Ada\Assistants\SassAssistant())->compile(resource_path("assets/sass"), $cssPath);

    $this->info("Sass compiled in $cssPath/*");
  }
}
