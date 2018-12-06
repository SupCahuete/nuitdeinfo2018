<?php

namespace Ada\Assistants;

use Storage;
use Image;

Class StorageAssistant extends Storage
{

  /**
   * Constructor.
   */
  public function __construct() {
    //
  }

  /**
   * Copy a storage's file to local public storage.
   *
   * @param $disk
   * @param $path
   * @param array $resize
   * @param bool $force
   *
   * @return bool
   */
  public function copyToPublic($disk, $path, $pahtTo = NULL, $resize = [], $force = FALSE)
  {
    if ( (! self::disk('public')->exists($path)) or $force) {

      // Get file content
      if (self::disk($disk)->exists($path)) {
        $content = self::disk($disk)->get($path);
      }
      else {
        return FALSE;
      }

      // Resize image
      if (count($resize) === 2) {
        // Make instance of the image.
        $img = Image::make($content);

        // Resize the image's instance.
        if (in_array(NULL, $resize)) {
          $img->resize($resize[0], $resize[1], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
        }
        else {
          $img->resize($resize[0], $resize[1]);
        }

        // Encode image as jpeg format.
        $content = $img->encode('jpg', 100)->getEncoded();
      }

      // Put file in public for web access
      self::disk('public')->put($pahtTo ?? $path, $content);
    }

    return TRUE;
  }

}