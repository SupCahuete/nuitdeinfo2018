<?php

namespace Ada\Monitors;

use Symfony\Component\Process\Process;

use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;
use Spatie\Regex\Regex;

class Diskspace extends CheckDefinition
{
  public $command = 'disk status';

  public function resolve(Process $process)
  {
    $percentage = $this->getDiskUsagePercentage($process->getOutput());

    $message = "usage at {$percentage}%";

    $thresholds = config('server-monitor.diskspace_percentage_threshold');

    if ($percentage >= $thresholds['fail']) {
      $this->check->fail($message);

      return;
    }

    if ($percentage >= $thresholds['warning']) {
      $this->check->warn($message);

      return;
    }

    $this->check->succeed($message);
  }

  protected function getDiskUsagePercentage(string $commandOutput): int
  {
    return (int) Regex::match('/(\d?\d)%/', $commandOutput)->group(1);
  }
}
