<?php

namespace Illuminate\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class TokenGuard implements Guard
{
  use GuardHelpers;

  /**
   * The request instance.
   *
   * @var \Illuminate\Http\Request
   */
  protected $request;

  /**
   * The name of the query string item from the request containing the API token.
   *
   * @var string
   */
  protected $inputKey;

  /**
   * The name of the token "column" in persistent storage.
   *
   * @var string
   */
  protected $storageKey;

  /**
   * Create a new authentication guard.
   *
   * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  public function __construct(UserProvider $provider, Request $request)
  {
    $this->request = $request;
    $this->provider = $provider;
    $this->inputKey = 'api_token';
    $this->storageKey = 'api_token';
  }

  /**
   * Attempt to authenticate a user using the given credentials.
   *
   * @param  array  $credentials
   * @param  bool   $remember
   * @param  bool   $login
   *
   * @return bool|\Illuminate\Contracts\Auth\Authenticatable
   */
  public function attempt(array $credentials = [], $remember = FALSE, $login = FALSE)
  {
    $user = $this->provider->retrieveByCredentials($credentials);

    if ($this->hasValidCredentials($user, $credentials)) {
      return $user;
    }

    return false;
  }

  /**
   * Determine if the user matches the credentials.
   *
   * @param  mixed  $user
   * @param  array  $credentials
   * @return bool
   */
  protected function hasValidCredentials($user, $credentials)
  {
    return ! is_null($user) && $this->provider->validateCredentials($user, $credentials);
  }

  /**
   * Get the currently authenticated user.
   *
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function user()
  {
    // If we've already retrieved the user for the current request we can just
    // return it back immediately. We do not want to fetch the user data on
    // every call to this method because that would be tremendously slow.
    if (! is_null($this->user)) {
      return $this->user;
    }

    $user = null;

    $token = $this->getTokenForRequest();

    if (! empty($token)) {
      $user = $this->provider->retrieveByCredentials(
        [$this->storageKey => $token]
      );
    }

    return $this->user = $user;
  }

  /**
   * Get the token for the current request.
   *
   * @return string
   */
  public function getTokenForRequest()
  {
    $token = $this->request->query($this->inputKey);

    if (empty($token)) {
      $token = $this->request->input($this->inputKey);
    }

    if (empty($token)) {
      $token = $this->request->bearerToken();
    }

    if (empty($token)) {
      $token = $this->request->getPassword();
    }

    return $token;
  }

  /**
   * Validate a user's credentials.
   *
   * @param  array  $credentials
   * @return bool
   */
  public function validate(array $credentials = [])
  {
    if (empty($credentials[$this->inputKey])) {
      return false;
    }

    $credentials = [$this->storageKey => $credentials[$this->inputKey]];

    if ($this->provider->retrieveByCredentials($credentials)) {
      return true;
    }

    return false;
  }

  /**
   * Set the current request instance.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return $this
   */
  public function setRequest(Request $request)
  {
    $this->request = $request;

    return $this;
  }
}
