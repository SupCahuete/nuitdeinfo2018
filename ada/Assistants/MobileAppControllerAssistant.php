<?php

namespace Ada\Assistants;

use Ada\Assistants\Traits\AndroidControllerAssistant;
use Ada\Assistants\Traits\IosControllerAssistant;

class MobileAppControllerAssistant
{

  use AndroidControllerAssistant, IosControllerAssistant;

  /**
   * Send notification app to android or ios.
   *
   * @param $title
   * @param $body
   * @param $os
   * @param $token
   *
   * @return boolean
   */
  public function sendToApp($title, $body, $os, $token)
  {
    if ($os == 'android') {
      return $this->androidNotification($title, $body, $token);
    }
    elseif ($os == 'ios') {
      return $this->iosNotification($title, $body, $token);
    }

    return FALSE;
  }

}
