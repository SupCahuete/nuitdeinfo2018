<?php
/*
|--------------------------------------------------------------------------|
|                           Additionals Helpers                            |
|--------------------------------------------------------------------------|
*/

use Illuminate\Support\Debug\Dumper;


if (! function_exists('str_finish_clear')) {
  /**
   * Clear a string end if search match.
   *
   * @param  string  $str
   * @param  string|array  $cap
   *
   * @return string
   */
  function str_finish_clear($str, $cap)
  {
    $clear = function ($str, $cap) {
      if (ends_with($str, $cap)) { return \Illuminate\Support\Str::replaceLast($cap, '', $str); }
      return $str;
    };

    if (is_array($cap)) {
      foreach ($cap as $st) {
        if (($strClear = $clear($str, $st)) != $str) {
          return $strClear;
        }
      }
    }
    else {
      return $clear($str, $cap);
    }

    return $str;
  }
}

if (! function_exists('str_start')) {
  /**
   * Start a string with a single instance of a given value.
   *
   * @param  string  $str
   * @param  string  $start
   *
   * @return string
   */
  function str_start($str, $start)
  {
    if (! starts_with($str, $start)) {
      return $start . $str;
    }

    return $str;
  }
}

if (! function_exists('str_start_clear')) {
  /**
   * Clear a string beginning if search match.
   *
   * @param  string  $str
   * @param  string|array  $start
   *
   * @return string
   */
  function str_start_clear($str, $start)
  {
    $clear = function ($str, $start) {
      if (starts_with($str, $start)) { return \Illuminate\Support\Str::replaceFirst($start, '', $str); }
      return $str;
    };

    if (is_array($start)) {
      foreach ($start as $st) {
        if (($strClear = $clear($str, $st)) != $str) {
          return $strClear;
        }
      }
    }
    else {
      return $clear($str, $start);
    }

    return $str;
  }
}

if (! function_exists('str_match')) {
  /**
   * Math sting in string.
   *
   * @param  string  $str
   * @param  string  $target
   *
   * @return string
   */
  function str_match($str, $target)
  {
    return strpos( $str, "$target") !== FALSE;
  }
}








/*
|
|
|--------------------------------------------------------------------------
| Helpers asset url
|--------------------------------------------------------------------------
|
|
*/
if (! function_exists('asset_url')) {
  /**
   * Generate a url of asset directory.
   *
   * @param  string  $path
   *
   * @return string
   */
  function asset_url($path = '')
  {
    return app('url')->asset("assets/$path");
  }
}

if (! function_exists('asset_url_image')) {
  /**
   * Generate a url of image's asset directory.
   *
   * @param  string  $path
   *
   * @return string
   */
  function asset_url_image($path = '')
  {
    return app('url')->asset("assets/img/$path");
  }
}

if (! function_exists('asset_url_css')) {
  /**
   * Generate a url of css's asset directory.
   *
   * @param  string  $path
   *
   * @return string
   */
  function asset_url_css($path = '')
  {
    return app('url')->asset("assets/css/$path");
  }
}

if (! function_exists('asset_url_js')) {
  /**
   * Generate a url of js's asset directory.
   *
   * @param  string  $path
   *
   * @return string
   */
  function asset_url_js($path = '')
  {
    return app('url')->asset("assets/js/$path");
  }
}

if (! function_exists('asset_url_font')) {
  /**
   * Generate a url of font's asset directory.
   *
   * @param  string  $path
   *
   * @return string
   */
  function asset_url_font($path = '')
  {
    return app('url')->asset("assets/fonts/$path");
  }
}

if (! function_exists('storage_public_url')) {
  /**
   * Generate a storage url.
   *
   * @param  string  $path
   * @param  string  $driver
   * @return string
   */
  function storage_public_url($path, $driver = 'guest')
  {
    return route('storage.get', [$driver, $path]);
  }
}







/*
|
|
|--------------------------------------------------------------------------
| Helpers asset path
|--------------------------------------------------------------------------
|
|
*/
if (! function_exists('asset_path')) {
  /**
   * Generate a asset path.
   *
   * @param  string  $path
   * @return string
   */
  function asset_path($path = '')
  {
    return app()->basePath().("/public/assets/$path");
  }
}

if (! function_exists('asset_image_path')) {
  /**
   * Generate a url of image's asset directory.
   *
   * @param  string  $path
   * @return string
   */
  function asset_path_image($path = '')
  {
    return app()->basePath().("/public/assets/img/$path");
  }
}

if (! function_exists('asset_css_path')) {
  /**
   * Generate a url of css's asset directory.
   *
   * @param  string  $path
   * @return string
   */
  function asset_path_css($path = '')
  {
    return app()->basePath().("/public/assets/css/$path");
  }
}

if (! function_exists('asset_js_path')) {
  /**
   * Generate a url of js's asset directory.
   *
   * @param  string  $path
   * @return string
   */
  function asset_path_js($path = '')
  {
    return app()->basePath().("/public/assets/js/$path");
  }
}

if (! function_exists('asset_font_path')) {
  /**
   * Generate a url of font's asset directory.
   *
   * @param  string  $path
   * @return string
   */
  function asset_path_font($path = '')
  {
    return app()->basePath().("/public/assets/fonts/$path");
  }
}







/*
|
|
|--------------------------------------------------------------------------
| Helpers override
|--------------------------------------------------------------------------
|
|
*/








/*
|
|
|--------------------------------------------------------------------------
| Helpers others
|--------------------------------------------------------------------------
|
|
*/

if(! function_exists('dfile')) {
  /**
   * Identical "d()" helper but .
   *
   * @param mixed $_
   *
   * @return void
   */
  function dfile($_ = NULL)
  {
    ob_start();

    array_map(function ($x) {
      (new Dumper)->dump($x);
    }, func_get_args());

    var_dump(func_get_args());

    $result = ob_get_clean();

    if (is_string($_) and strlen($_) < 100) {
      $path = base_path('storage/app/temp/' . str_replace(' ', '', $_) . '.html');
    }
    else {
      $path = base_path('storage/app/temp/' . \Carbon\Carbon::now()->format("Y-m-d_H-i-s") . '.html');
    }

    file_put_contents($path, $result);

  }
}

if (! function_exists('d')) {
  /**
   * Identical to dd() but without exit. See "dd()" in laravel 5.5 helpers's documentions.
   * @link https://laravel.com/docs/5.5/helpers#method-dd
   *
   * @param mixed $_
   *
   * @return void
   */
  function d($_ = NULL)
  {
    if (! func_num_args()) {
      die(1);
    }

    array_map(function ($x) {
      (new Dumper)->dump($x);
    }, func_get_args());
  }
}

if (! function_exists('tester')) {
  /**
   * //
   *
   * @param int $turns
   * @param $func
   *
   * @return void
   */
  function tester($turns, $func)
  {
    $microtime_float = function () {
      list($usec, $sec) = explode(" ", microtime());
      return ((float)$usec + (float)$sec);
    };

    $start = $microtime_float();

    for ($i = 1 ; $i <= $turns; $i++) {
      $func();
    }

    $end = $microtime_float() - $start;

    $debugInfo = debug_backtrace()[0]['file'] . ':' . debug_backtrace()[0]['line'];

    if (php_sapi_name() == "cli") {
      echo "\n$debugInfo\n.....Time: $end seconds\n";
    }
    else {
      echo "<br>$debugInfo<br>........Time: $end seconds<br>";
    }
  }
}








/*
|
|
|--------------------------------------------------------------------------
| Helpers constants
|--------------------------------------------------------------------------
|
|
*/


