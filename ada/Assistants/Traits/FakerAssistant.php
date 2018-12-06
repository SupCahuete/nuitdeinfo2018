<?php

namespace Ada\Assistants\Traits;

use AdaFile;

trait FakerAssistant
{

  /**
   * Create fake file.
   *
   * @return string
   */
  public function fakeFile($driver = NULL, $pathExtend = '', $size = 30, $imageName = NULL) {
    $driver = $driver ?? config('filesystems.default');
    $pathExtend = $pathExtend ? str_finish($pathExtend, '/') : $pathExtend;
    $imageName = $imageName ?? array_random(['color.jpg', 'umbrella.png', 'wood.jpg']);

    $from = resource_path("fake/img/$imageName");
    $extension = pathinfo($from)['extension'] ?? '.jpg';

    if (file_exists($from)) {
      do {
        $path = $pathExtend . str_random($size) . ".$extension" ;
        $to = config("filesystems.disks.$driver.root") . "/$path";
      } while(file_exists($to));

      AdaFile::makeDir(dirname($to));
      AdaFile::copy($from, $to);
    }
    else {
      $path = '';
    }

    return $path;
  }

}

