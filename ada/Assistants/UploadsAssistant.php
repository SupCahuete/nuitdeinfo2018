<?php

namespace Ada\Assistants;

use \Illuminate\Http\UploadedFile;

Class UploadsAssistant
{
  private $filesName = [];
  private $extentionDepreciated = [];
  private $errors = [];


  public function __construct() {
    //
  }


  public function uploadPicture(UploadedFile $file, $pathTo) {
    $extention = $file->getClientOriginalExtension();

    if (in_array($extention, $this->extentionDepreciated)) {
      array_push($this->errors, "L'Extention $extention n'est pas valide.");
      return FALSE;
    }

    $name = str_random(60) . "." .  $file->getClientOriginalExtension();

    return $this->uploadFile($file, $pathTo, $name);
  }


  private function uploadFile(UploadedFile $file, $pathTo, $name) {
    if ($file->isValid()) {
      $uploadResult = $file->move($pathTo, $name);

      array_merge($this->filesName, [
        $name => $uploadResult,
      ]);

      return $uploadResult;
    }

    return FALSE;
  }


  /*
   * Add array depreciated extentions
   */
  public function addExtentionDepreciated(Array $extentions) {
    array_push($this->extentionDepreciated, $extentions);
  }


  /*
   * FileName return
   */
  public function firstFile() {
    return $this->filesName[0];
  }
  public function allFiles() {
    return $this->filesName;
  }


  /*
   * Error return
   */
  public function firstError() {
    return $this->errors[0];
  }
  public function allErrors() {
    return $this->errors;
  }
}