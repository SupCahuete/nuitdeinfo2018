<?php

namespace Ada\Assistants\Traits;

trait ApiAssistant
{
  /**
   * @param array $data
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function response($data = []) {
    return response()->json(
      array_merge(['success' => TRUE], $data)
    );
  }

  /**
   * @param array $data
   * @param int $status
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function responseFail($data = [], $status = 200) {
    return response()->json(
      array_merge([
        'success' => FALSE,
        'type' => 'Fail',
    ], $data),
      $status
    );
  }

  /**
   * @param array $data
   * @param int $status
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function responseFailUnauthorized($data = [], $status = 200) {
    return response()->json(
      array_merge([
        'success' => FALSE,
        'type' => 'FailUnauthorized',
      ], $data),
      $status
    );
  }

  /**
   * @param array $data
   * @param int $status
   *
   * @return void
   */
  public function responseFailValidation($data = [], $status = 200) {
    $this->responseForced(
      response()->json( [
        'success' => FALSE,
        'type' => 'FailValidation',
        'errors' => $data
      ], $status)
    );
  }

  /**
   * @param array $data
   * @param int $status
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function responseUnauthorized($data = [], $status = 401) {
    return response()->json(
      array_merge([
        'success' => FALSE,
        'errors' => TRUE,
      ], $data),
      $status
    );
  }

  /**
   * @param array $data
   * @param int $status
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function responseError($data = [], $status = 500) {
    return response()->json(
      array_merge([
        'success' => FALSE,
        'errors' => TRUE,
      ], $data),
      $status
    );
  }


  /**
   * @param \Illuminate\Http\JsonResponse $response
   *
   * @return void
   */
  public function responseForced($response) {
    $response->send();
    exit();
  }
}

