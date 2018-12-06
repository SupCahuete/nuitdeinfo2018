<?php

namespace Ada\Console\Commands;

use Illuminate\Console\Command;


class CompilerViewsCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "compiler:view
                             {--name= : Compiles folder's name.}
                         ";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '';

  /**
   * @var string
   */
  protected $defaultLocale = 'lang-dev';

  /**
   * @var array
   */
  protected $locales;

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
    $this->locales = array_keys(config('app.locale_lc_all'));

    $paths = \AdaFile::allFiles(resource_path('views') . "/{$this->defaultLocale}");

    foreach ($paths as $path) {
      $file = file($path);

      $positions = $this->getTransFile($file, $path->getPathname());

      foreach ($this->locales as $locale) {
        // Set locale.
        \App::setLocale($locale);

        // Translate
        $fileTranslate = $this->translate($file, $positions);

        // Implode the file.
        $fileTranslate = $this->prepareFile($fileTranslate);

        // Create the translate's file.
        $pathTranslate = str_replace($this->defaultLocale, $locale, $path);
        \AdaFile::makeDir(dirname($pathTranslate));

        file_put_contents(str_replace($this->defaultLocale, $locale, $pathTranslate), $fileTranslate);
      }
    }

    $this->info("Success views compilation. Languages : " . strtoupper(implode(' ', $this->locales)));
  }

  /**
   * @param array $file
   * @param string $path
   *
   * @return array
   */
  protected function getTransFile($file, $path)
  {
    $toCompile = NULL;
    $find = FALSE;
    $start = NULL;
    $nbOpen = 1;
    $nbClose = 0;
    $bladeDirective = FALSE;

    $search = [
      // General
      '@config(',

      // Translate
      'trans(',
      '@lang(',

      // Translate mutiple choose
      'trans_choice(',
      '@choice(',

      // Assets
      '@image(',
      '@css(',
      '@js(',
    ];

    $pos = [];

    $lenFile = count($file);
    for ($n=0; $n<$lenFile; $n++) {
      $lenLine = strlen($file[$n]);
      for ($i=0; $i<$lenLine; $i++) {

        /*
         * Finded
         */
        if ($find) {
          $c = $file[$n][$i];

          $toCompile .= $c;

          if ($c === ')') {
            $nbClose++;
          }
          elseif ($c === '(') {
            $nbOpen++;
          }

          if ($nbOpen === $nbClose) {

            if ($bladeDirective) {
              $toCompile = substr($toCompile, 0, -1);
            }

            $pos[] = [
              'path' => $path,
              'blade' => $bladeDirective,
              'text' => $toCompile,
              'start' => $start,
              'end' => [
                0 => $n,
                1 => $i+1,
              ],
            ];

            $find = FALSE;
            $toCompile = NULL;
            $bladeDirective = FALSE;
            $nbOpen = 1;
            $nbClose = 0;
          }
        }
        /*
         * Start read
         */
        elseif ($toCompile) {
          $toCompile .= $file[$n][$i];
          $lenCompile = strlen($toCompile);

          if (
            $toCompile === substr(($searchFind = $search[0]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[1]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[2]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[3]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[4]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[5]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[6]), 0, $lenCompile) OR
            $toCompile === substr(($searchFind = $search[7]), 0, $lenCompile)
          ) {
            if ($lenCompile === strlen($searchFind) ) {
              $find = TRUE;

              if ($searchFind[0] === '@') {
                $bladeDirective = substr($searchFind, 0, -1);
                $toCompile = '';
              }
            }
          }
          else {
            $toCompile = NULL;
          }
        }
        /*
         * Search start
         */
        elseif (in_array($file[$n][$i], ['t', '@'])) {
          $toCompile = $file[$n][$i];
          $start = [
            0 => $n,
            1 => $i,
          ];
        }

      }
    }

    return array_reverse($pos);
  }

  /**
   * @param array $file
   * @param array $pos
   *
   * @return array
   */
  protected function translate($file, $pos) {
    $compiled = NULL;

    foreach ($pos as $p) {
      try {
        switch ($p['blade']) {
          case '@lang':
            eval( "\$compiled = trans( {$p['text']} );" );
            break;
          case '@choice':
            eval( "\$compiled = trans_choice( {$p['text']} );" );
            break;
          case '@config':
            eval( "\$compiled = config( {$p['text']} );" );
            break;
          case '@image':
            eval( "\$compiled = asset_url_image( {$p['text']} );" );
            break;
          case '@css':
            eval( "\$compiled = asset_url_css( {$p['text']} );" );
            break;
          case '@js':
            eval( "\$compiled = asset_url_js( {$p['text']} );" );
            break;
          default :
            eval( "\$compiled = {$p['text']} ;" );
            break;
        }
      }
      catch (\Exception $exception) {
        continue;
      }

      $file[ $p['start'][0] ] = substr_replace(
        $file[ $p['start'][0] ],
        $p['blade'] ? $compiled : "\"$compiled\"",
        $p['start'][1],
        $p['end'][1] - $p['start'][1]);

    }

    return $file;
  }

  /**
   * @param array $file
   *
   * @return string
   */
  protected function prepareFile($file) {
    return implode($file);
  }
}
