<?php

namespace Ada\Monitors;

use Symfony\Component\Process\Process;
use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;

class Ram extends CheckDefinition
{
  public $command = "ram status";

  public function resolve(Process $process)
  {
    $percentage = $this->getRamUsagePercentage($process);

    $message = "usage at {$percentage}%";

    $thresholds = config('server-monitor.memory_percentage_threshold');

    if ( ! $percentage or $percentage >= $thresholds['fail']) {
      $this->check->fail($message);

      return;
    }

    if ($percentage >= $thresholds['warning']) {
      $this->check->warn($message);

      return;
    }

    $this->check->succeed($message);
  }

  protected function getRamUsagePercentage($process) : string {
    return round( (float) $process->getOutput(), 2);
  }
}
