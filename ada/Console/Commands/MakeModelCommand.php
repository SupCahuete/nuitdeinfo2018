<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;

use Ada\Assistants\ConsoleAssistant;

class MakeModelCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:model
                            {name : Model's name.}
                            {--data : Specifie if use data in config/consoleData.php}
                            {--auth : Use authentification template.}
                            {--force : Force the creation.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create an model in app/Models/*';

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
   * @return mixed
   */
  public function handle()
  {
    $nameConfig = str_plural(lcfirst($this->argument('name')));
    $namePurge = $this->consoleAssistant->purgeStrWithMaj($nameConfig);
    $namePurge = str_singular($namePurge);

    $modelPath = base_path("app/Models/$namePurge.php");

    if ( ! $this->option('force') and AdaFile::exists($modelPath) )
    {
      $this->warn("\n\t[WarningAdaCommand]\n\tFile $namePurge already exists!\n\tPath: $modelPath");
      return;
    }

    $fillable = NULL;
    $hidden = NULL;

    if ($this->option('data'))
    {
      if (! ($fillableData = config("consoleData.$nameConfig.model.fillable")) ) {
        if ($fillableData = config("consoleData.$nameConfig.database")) {
          $fillableData = array_keys($fillableData);
          $fillableData = array_merge(['id'], $fillableData);
        }
      }

      if ($fillableData) {
        $line = 1;

        foreach ($fillableData as $key) {
          $fillable .= "'$key', ";

          if (strlen($fillable) >= 80*$line) {
            $fillable .= "\n\t\t";
            $line++;
          }
        }

        if ($hiddenData = config("consoleData.$nameConfig.model.hidden")) {
          foreach ($hiddenData as $key) {
            $hidden .= "'$key', ";

            if (strlen($hidden) >= 80*$line) {
              $hidden .= "\n\t\t";
              $line++;
            }
          }
        }
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tNot data in config/consoleData.\n\tCheck if 'model.fillable' or 'database' key exist in config/consoleData.php");
        return;
      }
    }

    if ($this->option('auth')) {
      $fillable = $fillable ?? "'email', 'password', 'api_token',";
      $hidden = $hidden ?? "'password', 'remember_token',";

      $templateName = "default-auth";
    }
    else {
      $fillable = $fillable ?? "// ";
      $hidden = $hidden ?? "// ";

      $templateName = "default";
    }

    $content = AdaFile::get(dirname(__FILE__) . "/../Templates/Models/$templateName.php");
    $content = str_replace("TAG_CLASS_NAME", $namePurge, $content);
    $content = str_replace("TAG_GUARD_NAME", lcfirst($namePurge), $content);
    $content = str_replace("/*TAG_FILLABLE*/", $fillable, $content);
    $content = str_replace("/*TAG_HIDDEN*/", $hidden, $content);

    AdaFile::put($modelPath, $content);
    $this->info("\nModel $namePurge created.\nPath: $modelPath");
  }
}
