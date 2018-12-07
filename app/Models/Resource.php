<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Ada\Assistants\Traits\RepositoryAssistant;

class Resource extends Model
{
  use RepositoryAssistant;

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
  public $incrementing = FALSE;

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
    '*'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    // 
  ];
}
