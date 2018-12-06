<?php

namespace Spatie\ServerMonitor\Commands;

use InvalidArgumentException;
use Spatie\ServerMonitor\Models\Enums\CheckStatus;

class AddHost extends BaseCommand
{
  protected $signature = 'server-monitor:add-host';

  protected $description = 'Add a host';

  public $defaultSshUser = 'godfather';

  public $defaultSshPort = 22;

  public static $stopChecks = '<stop checks>';

  public static $allChecksLabel = '<all checks>';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $this->defaultSshUser = config('server-monitor.ssh_user', $this->defaultSshUser);
    $this->defaultSshPort = config('server-monitor.ssh_port', $this->defaultSshPort);
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function handle()
  {
    $this->info("Let's add a host!");

    $hostName = $this->ask('What is the name of the host');

    if ($this->determineHostModelClass()::where('name', $hostName)->first()) {
      throw new InvalidArgumentException("Host `{$hostName}` already exist");
    }

    $sshUser = $this->ask("Which user?", $this->defaultSshUser);

    $port = $this->ask("Which port?", $this->defaultSshPort);

    $ip = $this->confirm('Should a specific ip address be used?')
      ? $this->ask('Which ip address?')
      : null;

    $checkNames = array_merge([static::$stopChecks, static::$allChecksLabel], $this->getAllCheckNames());
    $allCheckNames = $this->getAllCheckNames();
    $allChosenChecks = [];
    $chosenChecks = [];

    while (count($allChosenChecks) !== count($allCheckNames)) {
      $chosenChecks = $this->choice('Which checks should be performed?', $checkNames, 1, null, true);

      if ($chosenChecks[0] === static::$stopChecks) {
        if (count($allChosenChecks) > 0 ) {
          $chosenChecks = $allChosenChecks;
          break;
        }
        else {
          $this->info("Aborted.");
          return;
        }
      }
      elseif ($chosenChecks[0] === static::$allChecksLabel) {
        $chosenChecks = $allCheckNames;
        break;
      }

      unset($checkNames[array_search($chosenChecks[0], $checkNames)]);
      $allChosenChecks[] = $chosenChecks[0];
    }

    $this->determineHostModelClass()::create([
      'name' => $hostName,
      'ssh_user' => $sshUser,
      'port' => $port,
      'ip' => $ip,
    ])->checks()->saveMany(collect($chosenChecks)->map(function (string $checkName) {
      $checkModel = $this->determineCheckModelClass();

      return new $checkModel([
        'type' => $checkName,
        'status' => CheckStatus::NOT_YET_CHECKED,
        'custom_properties' => [],
      ]);
    }));

    $this->info("Host `{$hostName}` added.");
  }

  /**
   * @return array
   */
  protected function getAllCheckNames(): array
  {
    return array_keys(config('server-monitor.checks'));
  }
}
