<?php

namespace App\Providers;

use App;
use Blade;
use Config;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    /*
     * Define TimeZone.
     * Define Locale.
     */
    if ($accept = Arr::get($_SERVER, 'HTTP_ACCEPT_LANGUAGE')) {
      $locale = substr($accept, 0, 2);
    }
    else {
      $locale = config('app.locale');
    }
    if ( array_key_exists($locale, config('app.locale_lc_all')) ) {
      App::setLocale($locale);
      setlocale(LC_ALL, Config::get("app.locale_lc_all.$locale"));
      Carbon::setLocale($locale);
    }
    else {
      $locale = App::getLocale();
      setlocale(LC_ALL, Config::get("app.locale_lc_all.$locale"));
      Carbon::setLocale($locale);
    }



    /*
     * Blade extented
     */

    // Debug
    Blade::directive('d', function ($expression) {
      return "<?php d($expression); ?>";
    });
    Blade::directive('dd', function ($expression) {
      return "<?php dd($expression); ?>";
    });
    Blade::directive('var_dump', function ($expression) {
      return "<?php var_dump($expression); ?>";
    });

    // Config
    Blade::directive('config', function ($expression) {
      return "<?php echo config($expression); ?>";
    });

    // Route
    Blade::directive('route', function ($expression) {
      return "<?php echo route($expression); ?>";
    });

    // Assets
    Blade::directive('image', function ($expression) {
      return "<?php echo asset_url_image($expression); ?>";
    });
    Blade::directive('css', function ($expression) {
      return "<?php echo asset_url_css($expression); ?>";
    });
    Blade::directive('js', function ($expression) {
      return "<?php echo asset_url_js($expression); ?>";
    });

    // Public storage
    Blade::directive('storage', function ($expression) {
      return "<?php echo storage_public_url($expression); ?>";
    });

  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }
}
