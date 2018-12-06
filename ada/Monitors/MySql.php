<?php

namespace Ada\Monitors;

use Symfony\Component\Process\Process;
use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;

class MySql extends CheckDefinition
{
  public $command = 'mysql status';

  public function resolve(Process $process)
  {
    if (str_contains($process->getOutput(), 'Active: active')) {
      $this->check->succeed('is running');

      return;
    }

    $this->check->fail('is not running');
  }
}