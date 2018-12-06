<?php

namespace Ada\Assistants\Traits;

use Ada\Assistants\CurlAssistant;
use Illuminate\Support\Facades\Log;

trait AndroidControllerAssistant
{

  /**
   * @var CurlAssistant
   */
  protected $CURL;

  /**
   * Send android notification app.
   *
   * @param $title
   * @param $body
   * @param $token
   *
   * @return boolean
   */
  public function androidNotification($title, $body, $token)
  {
    $this->CURL = new CurlAssistant;

    $api_key = config('services.firebase.secret');

    asset_url_image('andoid/ic_launcher.png');

    $response =
      $this->CURL->url('https://fcm.googleapis.com/fcm/send')
                 ->header("Authorization: key=$api_key")
                 ->json()
                 ->info()
                 ->timeout(10)
                 ->data([
                  'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'icon' => 'ic_launcher',
                    'sound' => 'default',
                    //'color' => '#022041',
                  ],
                  'to' => $token,
                 ])
                 ->post();

    d($this->CURL, $response);

    if ($response->status === 200 and $response->error === FALSE) {
      if ($response->content['success']) {
        return TRUE;
      }

      Log::alert(json_encode($response->content['results']));
    }

    return FALSE;
  }

}
