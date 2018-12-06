<?php

namespace Ada\Assistants\Traits;

use Ada\Assistants\CurlAssistant;
use Illuminate\Support\Facades\Log;

trait IosControllerAssistant
{

  /**
   * @var CurlAssistant
   */
  protected $CURL;

  /**
   * Send ios notification app.
   *
   * @param $title
   * @param $body
   * @param $token
   *
   * @return boolean
   */
  public function iosNotification($title, $body, $token)
  {
    $this->CURL = new CurlAssistant;

    $appleDomain = env('APP_ENV') == 'production' ? 'api.push.apple.com' : 'api.development.push.apple.com';

    $response = $this->CURL->url("https://$appleDomain")
      ->header('apns-topic: com.nassaudrive.nassaudrivers')
      ->header(":method: POST")
      ->header(":path: /3/device/$token")
      ->cert( base_path("cert/apple/aps_development.pem") )
      ->notSecure()
      ->json()
      ->info()
//      ->timeout(10)
      ->data([
        'aps' => [
          'alert' => $title,
          'sound' => 'default',
        ]
      ])
      ->debug(storage_path('app/temp/CURL'))
      ->post();

    if ($response->status === 200 and $response->error === FALSE) {
      if ($response->content['success']) {
        return TRUE;
      }

      Log::alert(json_encode($response->content['results']));
    }

    return FALSE;
  }

}
