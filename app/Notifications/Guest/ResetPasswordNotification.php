<?php

namespace App\Notifications\Frontuser;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
  use Queueable;

  /**
   * The password reset token.
   *
   * @var string
   */
  public $token;

  /**
   * Create a new notification instance.
   *
   * @param string $token
   *
   * @return void
   */
  public function __construct($token)
  {
    $this->token = $token;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   *
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   *
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $trans =  trans('notif.email.reset');

    return (new MailMessage)
      ->subject( config('app.name') . ' - ' . $trans['password'] )
      ->greeting("")
      ->line( $trans['line1'] )
      ->action( $trans['password'], route('frontuser.resetPassword.index', $this->token) )
      ->line( $trans['line2'] );
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   *
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
