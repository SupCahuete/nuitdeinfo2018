<?php

namespace Ada\Assistants\Traits;

use Ramsey\Uuid\Uuid;

trait RepositoryAssistant
{
  /**
   * Create a uuid type 1.
   *
   * @return string
   */
  public static function uuid1() {
    return Uuid::uuid1()->toString();
  }

  /**
   * Create a uuid type 4.
   *
   * @return string
   */
  public static function uuid4() {
    return Uuid::uuid4()->toString();
  }

  /**
   * Return a new api token for the authentification's user.
   *
   * @return string
   */
  public static function getNewApiToken() {
    return str_random(60);
  }

//  /**
//   * Boot function from laravel.
//   */
//  protected static function boot()
//  {
//    parent::boot();
//
//    static::creating(function ($model) {
//      $model->{$model->getKeyName()} = Uuid::uuid1()->toString();
//    });
//  }

}

