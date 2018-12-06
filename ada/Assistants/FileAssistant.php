<?php

namespace Ada\Assistants;

use \Illuminate\Filesystem\Filesystem as File;

class FileAssistant extends File
{

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
   * //
   *
   * @param string $path
   * @param array $data
   * @param array $excepts
   *
   * @return void
   */
  public function jsonUpdate($path, $data, $excepts = []) {
    if (file_exists($path)) {
      $jsonString = file_get_contents($path);
      $dataJson = json_decode($jsonString, true);
    }
    else {
      $dataJson = [];
    }
    
    foreach ($data as $key => $val) {
      if (array_key_exists($key, $dataJson) and ! in_array($key, $excepts)) {
        $keyType = gettype($val);

        if ($keyType == gettype($dataJson[$key])) {
          if ($keyType=="integer" or $keyType=="double"  ) {
            $dataJson[$key] += $val;
          }
          elseif ($keyType == "string") {
            $dataJson[$key] .= $val;
          }
          elseif ($keyType == "array") {
            $dataJson[$key] = array_merge($dataJson[$key], [$key => $val]);
          }
          else {
            $dataJson = array_merge($dataJson, [$key => $val]);
          }
        }
        else {
          $dataJson = array_merge($dataJson, [$key => $val]);
        }
      }
      else {
        $dataJson = array_merge($dataJson, [$key => $val]);
      }
    }

    parent::put($path, json_encode($dataJson));
  }

  /**
   * Delete file if exist.
   *
   * @param string $path
   *
   * @return void
   */
  public function deleteFileIfExist($path) {
    if (file_exists($path)) {
      unlink($path);
    }
  }

  /**
   * Forces the creation of a directory with recursion.
   *
   * @param string $path
   * @param int $mode
   * @param boolean $cap
   *
   * @return boolean
   */
  public function makeDir($path, $mode = 0755, $cap = FALSE) {
    if ($cap) {
      return $this->makeDirCapitalize($path, $mode);
    }

    return @mkdir($path, $mode, TRUE);
  }

  /**
   * Force the creation of a directory with recursion and capitalization.
   *
   * @param string $path
   * @param int $mode
   *
   * @return boolean
   */
  public function makeDirCapitalize($path, $mode = 0755) {
    $path = ucwords($path, '/\\.');

    return @mkdir($path, $mode, TRUE);
  }

  /**
   * Normalize the path with Unix directory separator.
   *
   * @param string $str
   *
   * @return string
   */
  public function normalizePath($str) {
    $str = str_replace(['\\', '.'], '/', $str);

    return $str;
  }
}
