<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPasswordNotification;

use Ada\Assistants\Traits\RepositoryAssistant;

class TAG_CLASS_NAME extends Authenticatable
{
  use Notifiable, RepositoryAssistant;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  //protected $primaryKey = 'id';

  /**
   * The "type" of the auto-incrementing ID.
   *
   * @var string
   */
  //protected $keyType = 'int';

  /**
   * The number of models to return for pagination.
   *
   * @var int
   */
  //protected $perPage = 15;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  //public $incrementing = true;

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  //public $timestamps = true;

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['*'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    /*TAG_FILLABLE*/
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    /*TAG_HIDDEN*/
  ];

  /** Overrride
   * Send the password reset notification.
   *
   * @param  string  $token
   *
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPasswordNotification($token, 'TAG_GUARD_NAME'));
  }

  /**
   * Route notifications for the mail channel.
   *
   * @return string
   */
  public function routeNotificationForMail()
  {
    return $this->email;
  }
}
