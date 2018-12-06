<?php

namespace App\Http\Controllers\Api\Frontuser;

use Illuminate\Http\Request;

use App\Http\ControllersSyndicate\Frontuser\Controller as BaseController;

use Ada\Assistants\Traits\ApiAssistant;

class Controller extends BaseController
{
  use ApiAssistant;

  /**
   * Guard name of the controller.
   *
   * @var string
   */
  protected $guard = AuthInterface::GUARD;

  /**
   * Validate the given request with the given rules.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  array  $rules
   * @param  array  $messages
   * @param  array  $customAttributes
   *
   * @return void
   */
  public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
  {
    $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

    if ($validator->fails()) {
      $this->responseFailValidation($validator->getMessageBag()->toArray());
    }
  }

}
