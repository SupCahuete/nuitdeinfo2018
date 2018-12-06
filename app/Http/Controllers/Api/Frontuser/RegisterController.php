<?php

namespace App\Http\Controllers\Api\Frontuser;

use Ada\Assistants\FileAssistant;
use Ada\Assistants\UploadsAssistant;
use Auth;

use App\Http\Requests\Frontuser\RegisterRequest;
use App\Models\Frontuser;

use Ada\Assistants\StorageAssistant;
use Ada\Assistants\Traits\ApiAssistant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use ApiAssistant;

  /**
   * @var Frontuser
   */
  protected $frontuser;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  RegisterRequest  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(RegisterRequest $request)
  {
    // Get datas.
    $inputs = $request->onlyFromRules();

    // Init frontuser's model.
    $this->frontuser = new Frontuser();

    // Password
    $inputs['password'] = bcrypt($inputs['password']);

    // Phone
    $inputs['phone'] = Frontuser::phone($inputs['phone']);

    // Check cgv & cgu accept.
    $inputs['cgu_accept'] = TRUE;
    $inputs['cgv_accept'] = TRUE;

    // Add ID.
    $inputs['id'] = $this->frontuser->uuid4();

    // Add api_token.
    $inputs['api_token'] = $this->frontuser->getNewApiToken();

    // Upload file_picture in s3 or use the default file_picture.
    if (is_null($file_picture = $request->file('file_picture')))
    {
      $inputs['file_picture'] = "{$inputs['id']}/" . str_random(25) . '.png';

      $copy = (new FileAssistant())->copy(
        config('filesystems.disks.local.root').'/img/file_picture.png',
        config("filesystems.disks.{$this->userDiskS3}.root") . "/{$inputs['file_picture']}"
      );

      if (! $copy) {
        return $this->responseError();
      }
    }
    else {
      $inputs['file_picture'] = (new UploadsAssistant())->uploadPicture($this->userDiskS3, $file_picture, $inputs['id']);
    }

    // Create user in DB.
    $this->frontuser = $this->frontuser->create($inputs);

    if (! $this->frontuser) {
      return $this->responseError();
    }

    // Stripe
    try {
      $this->frontuser->createAsStripeCustomer($request->input('stripe_token'));
    }
    catch (\Exception $exception)
    {
      \Log::info($request->ip() . ' -- ' . json_encode($this->frontuser->toArray()) . ' -- ' . $exception->getMessage());

      $this->deleteUser();

      return $this->responseFail([
        'code' => 'INVALID_CARD',
        'errors' => ['Votre carte a été refusée. Essayez en une autre ou contactez le support.'],
        'message' => 'Votre carte a été refusée. Essayez en une autre ou contactez le support.'
      ]);
    }

    // file_picture copy to public.
    (new StorageAssistant())->copyToPublic($this->userDiskS3, $inputs['file_picture'], [150, NULL]);

    // Add card_exp
    $card = $this->frontuser->cards()->first();
    $this->frontuser->card_exp = Carbon::create($card->exp_year, $card->exp_month)->startOfMonth()->timestamp;
    $this->frontuser->save();

    // Send mail to new frontuser.
    Mail::to($this->frontuser->email)->send(
      new \App\Mail\Frontuser\Register([
        'name' => $this->frontuser->last_name,
      ])
    );

    return $this->response([
      'api_token' => $inputs['api_token']
    ]);
  }

  /** Override
   * Get the guard to be used during registration.
   *
   * @return \Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard()
  {
    return Auth::guard('frontuser');
  }

  /**
   * Delete user.
   *
   * @return boolean
   */
  protected function deleteUser()
  {
    try {
      Storage::disk($this->userDiskS3)->deleteDirectory($this->frontuser->id);
    }
    catch (\Exception $exception) {}

    return $this->frontuser->delete();
  }

}
