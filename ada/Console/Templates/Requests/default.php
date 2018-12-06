<?php

namespace TAG_NAMESPACE_NAME;

use App\Http\Requests\Request;

class TAG_CLASS_NAME extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return TRUE;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      /*TAG_RULES*/
    ];
  }
}
