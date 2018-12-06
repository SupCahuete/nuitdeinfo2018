<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;

use Ada\Assistants\ConsoleAssistant;

class MakeMigrationCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:migration {name : Migration's name (Words not accepts -> table, create).}
                          {--template= : Specifie a template.}
                          {--force : Force the creation.}
                          {--data : Specifie if use data in config/consoleData.php}";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Create a migration in database/migrations/*";

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
    $dirMigration = base_path("database/migrations/");

    $namePurge = $this->consoleAssistant->purgeStrWithMaj($this->argument('name'), [
      'table', 'create',
    ]);

    $nameConfig = lcfirst($namePurge);

    $migrationClassName = "Create" . $namePurge . "Table";
    $migrationTableName = snake_case($namePurge);

    $nbFile = strval(count(AdaFile::files($dirMigration)));


    $diffFile = (4-strlen($nbFile));
    if ($diffFile < 0) { $diffFile = 0; }

    $migrationPathDefault = snake_case($migrationClassName) . ".php";
    $migrationPathRegex = "$dirMigration*$migrationPathDefault";
    $migrationPath = $dirMigration . "2017_01_01_" . str_repeat('0', $diffFile) . $nbFile . "000_". $migrationPathDefault;

    if ( ($glob = AdaFile::glob($migrationPathRegex)) != [] ) {
      if (! $this->option('force')) {
        $this->error("\n\t[ErrorAdaCommand]\n\tFile *$migrationPathDefault already exists!\n\tPath: $migrationPathRegex");
        return;
      }

      $migrationPath = $glob[0];
    }

    if ($this->option('data')) {
      if ($database = config("consoleData.$nameConfig.database")) {
        $columnDatabase = "";

        foreach ($database as $key => $type) {
          if (in_array($type, ['password', 'passwords'])) { $type = 'string'; }

          if (in_array($type, ['remember_token', 'rememberToken'])) {
            $columnDatabase .= "\$table->rememberToken();\n\t\t\t";
            continue;
          }

          $columnDatabase .= "\$table->$type('$key');\n\t\t\t";
        }

        $columnDatabase = str_finish_clear($columnDatabase, "\n\t\t\t");

        if (! $foreignKeysArray = config("consoleData.$nameConfig.database-foreignkeys")) {
          $foreignKeys = "";
        }
        else {
          $foreignKeys = "";
          foreach ($foreignKeysArray as $key => $on) {
            $key = str_replace("_id", "", $key) . "_id";
            $foreignKeys .= "'$key' => '$on',\n\t\t";
          }
        }
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tconfig('consoleData.$nameConfig.database') return null.\n\tCheck if 'database' exist in config/consoleData.php");
        return;
      }
    }
    else {
      $foreignKeys = "";
      $columnDatabase = "//\$table->string('name', 60);";
    }

    if ($template = $this->option('template'))
    {
      $template = str_finish($template, ".php");

      $templatePath = dirname(__FILE__) . "/../Templates/Migrations/$template";

      if ( ! AdaFile::exists($templatePath)) {
        $this->error("\n\t[ErrorAdaCommand]\n\tTemplate not exist.\n\tPath: $templatePath");
        return;
      }
    }
    else {
      $templatePath = dirname(__FILE__) . "/../Templates/Migrations/default.php";
    }

    $content = AdaFile::get($templatePath);
    $content = str_replace("CLASS_NAME", $migrationClassName, $content);
    $content = str_replace("TABLE_NAME", $migrationTableName, $content);
    $content = str_replace("//FOREIGN_KEYS", $foreignKeys, $content);
    $content = str_replace("//\$table->string('name', 60);", $columnDatabase, $content);

    AdaFile::put($migrationPath, $content);
    $this->info("\nMigration {$migrationClassName} created.\nPath: {$migrationPath}");
  }
}
