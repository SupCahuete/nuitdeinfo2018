<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;
use AdaFile;
use AdaConsole;
use Ramsey\Uuid\Uuid;

class MakeSeederCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "make:seeder 
                          {name : Seeder's name (Words not accepts -> table, seed).}
                          {--data : Specify if use data in config/consoleData.php}
                          {--template= : Specify a template.}
                          {--enable : Specify if to enable the seeder.}";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Create an seeder in database/seeds/*";
  

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
   * @return mixed
   */
  public function handle()
  {
    $template = $this->option('template');
    $templateUuid = 'default-uuid';

    $namePurge = AdaConsole::purgeStrWithMaj($this->argument('name'), [
      'table', 'seeder', 'seeds', 'seed',
    ]);

    $nameConfig = lcfirst($namePurge);
    $seederModelName = str_singular($namePurge);
    $seederClassName = $namePurge . "TableSeeder";
    $seederTableName = snake_case($namePurge);

    $seederPath = base_path("database/seeds/{$seederClassName}.php");

    if (AdaFile::exists($seederPath))
    {
      $this->error("\n\t[ErrorAdaCommand]\n\tFile {$seederClassName} already exists!\n\tPath: {$seederPath}");
      return;
    }

    if ($this->option('data')) {
      if ($database = config("consoleData.$nameConfig.database")) {
        $columnDatabase = "";
        $excludeType = [
          'rememberToken'
        ];

        foreach ($database as $key => $type)
        {
          if ($key == 'api_token') {
            $data = "str_random(60), // String";
          }
          elseif ($key == 'email') {
            $data = "\"eric\$i@test.com\", // String";
          }
          elseif ($type == "uuid") {
            if ($template != $templateUuid) {
              $this->warn("\n\t[WarnAdaCommand]\n\tThe type \"uuid\" requires the template \"default-uuid\".");
              return;
            }
            else {
              $uuid = Uuid::uuid4()->toString();
              $data = "$seederModelName::uuid4(), // Uuid: $uuid";
            }
          }
          elseif ($type == "string") {
            $data = "'string'.\$i, // String";
          }
          elseif (in_array($type, ['password', 'passwords'])) {
            $data = "bcrypt(\"eric\$i\"), // String";
          }
          elseif ($type == "text") {
            // "'Lorem ipsum dolor sit amet.', // Text"
            $data = "'Test', // Text";
          }
          elseif ($type == "tinyInteger") {
            $data = rand(0, 250) . ", // Tinyint";
          }
          elseif ($type == "smallInteger") {
            $data = rand(0, 60000) . ", // Smallint";
          }
          elseif ($type == "integer") {
            $data = rand(0, 60000) . ", // Integer";
          }
          elseif ($type == "float") {
            $data = "1234.1234, // Float";
          }
          elseif ($type == "double") {
            $data = "1234.123456789, // Double";
          }
          elseif ($type == "boolean") {
            $data = array('TRUE', 'FALSE')[rand(0,1)] . ", // Boolean";
          }
          elseif ($type == "date") {
            $data = "'2018-02-15', // Date";
          }
          elseif ($type == "timestamp") {
            $data = "\Carbon\Carbon::now()->toIso8601String(), // Timestamp";
          }
          elseif (in_array($type, ['json', 'jsonb'])) {
            $data = "json_encode([]), // " . ucfirst($type);
          }
          else {
            $data = "'UNKNOWN TYPE', // ";
          }

          if (! in_array($type, $excludeType)) {
            $columnDatabase .= "'$key' => $data\n\t\t\t\t";
          }
        }

        if ($template == $templateUuid) {
          $uuid = Uuid::uuid4()->toString();
          $columnDatabase = "'id' => $seederModelName::uuid4(), // Uuid: $uuid\n\t\t\t\t" . $columnDatabase;
        }

        if ($foreignKeysArray = config("consoleData.$nameConfig.database-foreignkeys")) {
          foreach ($foreignKeysArray as $key => $on) {
            $key = str_replace("_id", "", $key);
            $key .= "_id";
            $columnDatabase .= "'$key' => \$i, // Foreign Key\n\t\t\t\t";
          }
        }
      }
      else {
        $this->error("\n\t[ErrorAdaCommand]\n\tconfig('consoleData.$nameConfig.database') return null.\n\tCheck if 'database' exist in config/consoleData.php");
        return;
      }
    }
    else {
      $columnDatabase = "// 'name' => 'Eric'.\$i,";
    }

    if ($this->option("enable")) {
      $callSeeder = "\$this->call($seederClassName::class);\n\t\t/*TAG_CALL_SEEDER*/";
      $path = database_path("seeds/DatabaseSeeder.php");

      $content = str_replace("/*TAG_CALL_SEEDER*/", $callSeeder, AdaFile::get($path));
      AdaFile::put($path, $content);
    }

    if ($template) {
      $content = AdaFile::get(dirname(__FILE__) . "/../Templates/Seeds/$template.php");
    }
    else {
      $content = AdaFile::get(dirname(__FILE__) . "/../Templates/Seeds/default.php");
    }

    $content = str_replace("TAG_MODEL_NAME", $seederModelName, $content);
    $content = str_replace("TAG_CLASS_NAME", $seederClassName, $content);
    $content = str_replace("TAG_TABLE_NAME", $seederTableName, $content);
    $columnDatabase = str_finish_clear($columnDatabase, "\n\t\t\t\t");
    $content = str_replace("/*TAG_COLUMN*/", $columnDatabase, $content);

    AdaFile::put($seederPath, $content);

    $this->info("\nSeeder $seederClassName created.\nPath: $seederPath");
    $this->warn("Launch: composer dumpautoload");
  }
}
