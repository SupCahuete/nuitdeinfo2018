<?php
namespace Ada\Support\Facades;

use Illuminate\Support\Facades\Facade;

class MapAssistant extends Facade {
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'Ada\Assistants\MapAssistant';
  }
}
