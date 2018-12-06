<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Ada\Assistants\Traits\RepositoryAssistant as Repository;

class Frontuser extends Authenticatable
{

  use Notifiable, Repository;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = FALSE;

  /**
   * Table's name.
   *
   * @var string
   */
  protected $table = 'frontusers';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',

    'email',
    'password',
    'api_token',

    'first_name',
    'last_name',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
  ];

  /**
   * Send the password reset notification.
   *
   * @param  string  $token
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new \App\Notifications\Frontuser\ResetPasswordNotification($token));
  }

}
