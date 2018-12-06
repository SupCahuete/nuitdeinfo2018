<?php

namespace Ada\Assistants;

use Carbon\Carbon;
use Mail;

class EmailAssistant
{

  /**
   * //
   *
   * @param array $dataErrors
   * @param $title
   *
   * @return void
   */
  public function error(Array $dataErrors, $title) {
    $dataErrors = print_r($dataErrors, TRUE);

    Mail::send('master.email.error', ['dataErrors' => $dataErrors, 'title' => $title], function($msg) use($title) {
      $msg->to($_SERVER('ERROR_EMAIL'))
          ->subject($title);
    });

    if(count(Mail::failures()) > 0)
    {
      $date = Carbon::now();

      $msg = "############### {$date}\n";
      $msg .= $dataErrors;
      $msg .= "###############\n\n\n\n";

      $pathLogFile = base_path()."\\storage\\logs\\errors.log";

      FileAssistant::append($pathLogFile, $msg);
    }
  }
}
