<?php

namespace Ada\Assistants;

use \Leafo\ScssPhp\Compiler as CompilerSass;
use AdaFile;

class SassAssistant
{
  /**
   * Supported formats .
   *
   * @var array
   */
  protected $formats = [
    'crunched' => "Leafo\ScssPhp\Formatter\Crunched",
    'compressed' => "Leafo\ScssPhp\Formatter\Compressed",
  ];

  /**
   * @var array
   */
  protected $variables = [
    //
  ];

  /**
   * @var array
   */
  protected $excepts = [
    '_variables.scss',
    'main.scss',
  ];

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Compiles the .scss files in a given folder into .css files in a given folder.
   *
   * @param string $sassDir
   * @param string $cssDir
   * @param string $format
   *
   * @return bool
   */
  public function compile($sassDir, $cssDir, $format = "crunched")
  {
    $format = strtolower($format);
    $sassDir = str_finish_clear($sassDir, '/');
    $cssDir = str_finish_clear($cssDir, '/');

    // get all .scss files from sass folder
    $files = $this->filesInit($sassDir, $cssDir);

    // Initialize class.
    $sass = new CompilerSass();

    // Set the output format.
    $sass->setFormatter($this->formats[$format]);

    // Add variables.
    if (! empty($this->variables)) $sass->setVariables($this->variables);

    // step through all .scss files in that folder
    foreach ($files as $file)
    {
      if (in_array(basename($file->sassPath), $this->excepts)) continue;

      $sass->setImportPaths(dirname($file->sassPath));

      $cssPath = strtolower($file->cssPath);
      $basePathLower = strtolower(base_path());
      $cssPath = str_replace($basePathLower, base_path(), $cssPath);

      // do not compile if sass has not been recently updated
      if (realpath($cssPath) and ! filemtime($file->sassPath) > @filemtime($cssPath)) continue;

      // get sass's content, put it into $content
      $content = file_get_contents($file->sassPath);

      // compile this SASS code to CSS
      $content = $sass->compile($content);

      // make directory with recursive.
      if (! AdaFile::exists(dirname($cssPath))) {
        AdaFile::makeDir(dirname($cssPath));
      }

      file_put_contents($cssPath, $content);
    }

    return TRUE;
  }

  /**
   * Create the sass and css's path for each files.
   *
   * @param string $sassDir
   * @param string $cssDir
   *
   * @return array
   */
  private function filesInit($sassDir, $cssDir) {
    $files = [];

    foreach (AdaFile::allFiles($sassDir) as $file) {
      $fileInfo = new \stdClass();
      $fileInfo->sassPath = $file->getPathname();
      $fileInfo->cssPath = "$cssDir/" . str_replace('.scss', '.css', $file->getRelativePathname());

      array_push($files, $fileInfo);
    }

    return $files;
  }
}
