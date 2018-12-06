<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Exemple extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * @var array
   */
  protected $data;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Welcome !')
                ->view('frontuser.layouts.email')
                ->with([
                  'title' => "Welcome {$this->data['name']}",
                  'lines' => [
                    'Welcome my friend.'
                  ],
                  'link' => [
                    'url' => route('frontuser.home.index'),
                    'text' => 'GO'
                  ],
                ]);
  }
}
