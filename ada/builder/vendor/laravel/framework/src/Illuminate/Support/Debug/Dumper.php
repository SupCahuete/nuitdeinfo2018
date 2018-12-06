<?php

namespace Illuminate\Support\Debug;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class Dumper
{
  /**
   * Dump a value with elegance.
   *
   * @param  mixed  $value
   * @return void
   */
  public function dump($value)
  {
    if (class_exists(CliDumper::class)) {
      $dumper = 'cli' === PHP_SAPI ? new CliDumper : new HtmlDumper;

      $cloner = new VarCloner();
      $cloner->setMaxItems(10000);

      $dumper->dump($cloner->cloneVar($value));
    }
    else {
      var_dump($value);
    }
  }
}
