<?php

namespace Ada\Assistants;

use AdaFile;

class ConsoleAssistant
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    //
  }

  /**
   * Purge String with majuscule case.
   *
   * @param string $str
   * @param array $replace
   *
   * @return string
   */
  public function purgeStrWithMaj($str, Array $replace = []) {
    $under = $str[0] === '_';

    $replace = array_merge($replace, ['.php']);

    $str = str_replace('\\', '/', $str);

    $str = class_basename($str);
    $str = snake_case($str);

    foreach ($replace as $word) {
      $str = str_replace($word, '', $str);
    }

    $str = camel_case($str);

    if ($under) {
      $str = "_$str";
    }
    else {
      $str = ucfirst($str);
    }
    
    return $str;
  }

  /**
   * Purge String with underscord.
   *
   * @param string $str
   * @param array $replace
   *
   * @return string
   */
  public function purgeStrWithUnderscord($str, Array $replace = []) {
    $replace = array_merge($replace, ['.php']);

    $str = str_replace('\\', '/', $str);

    $str = class_basename($str);
    $str = snake_case($str);

    foreach ($replace as $word) {
      $str = str_replace($word, '', $str);
    }

    $str = camel_case($str);
    $str = snake_case($str);

    return $str;
  }

  /**
   * Return a instance of Class invoked with a string.
   *
   * @param string $class
   *
   * @return object|boolean
   */
  public function buildClassByString($class) {
    $class = str_replace(['/'], '\\', $class);

    $path = str_finish($class, '.php');
    $path = str_replace(['\\'], '/', $path);
    $path = base_path($path);

    if (AdaFile::exists($path)) {
      return new $class();
    }

    return FALSE;
  }
}
