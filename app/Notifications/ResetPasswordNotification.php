<?php

namespace App\Notifications;

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
   * Specifie the guard.
   *
   * @var string
   */
  public $guard;

  /**
   * Create a new notification instance.
   *
   * @param string $token
   *
   * @return void
   */
  public function __construct($token, $guard = NULL)
  {
    $this->token = $token;
    $this->guard = $guard ?? config('auth.defaults.guard');
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
      ->action( $trans['password'], route( $this->guard . '.resetPassword.index', $this->token ) )
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
