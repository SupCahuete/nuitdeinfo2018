<?php

namespace Ada\Assistants;

use GoogleMaps\GoogleMaps;

use Ada\Assistants\CurlAssistant;

class GoogleApiAssistant
{
  /**
   * @var CurlAssistant
   */
  protected $CURL;

  /**
   * Google Maps Api key.
   *
   * @var string
   */
  protected $key;

  /**
   * Google Maps Api URL.
   *
   * @var string
   */
  protected $baseUrl = "https://maps.googleapis.com/maps/api/";

  /**
   * Countries uses.
   *
   * @var array
   */
  protected $countries = [
    'fr'
  ];

  /**
   * Constructor.
   */
  public function __construct()
  {
    $this->key = config('services.google.maps');
    $this->CURL = new CurlAssistant;
  }

  /**
   * //
   *
   * @param string $place
   * @param string $latlng
   *
   * @return string
   */
  public function places($place, $latlng)
  {
    $responseJson = GoogleMaps::load('placeautocomplete')
      ->setParam([
        'input' => $place,
        'location' => $latlng,
        'radius' => 20000,
        'components' => [
          'country'   => 'fr'
        ],
      ])
      ->get();

    return $responseJson;
  }

  /**
   * Google maps directions.
   *
   * @param string $origin
   * @param string $destination
   *
   * @return bool|mixed
   */
  public function directions($origin, $destination)
  {
    $responseJson = GoogleMaps::load('directions')
      ->setParam([
        'origin' => $origin,
        'destination' => $destination,
        'mode' => 'driving',
        'language' => 'fr',
        'region' => 'fr',
      ])
      ->get();

    $response = json_decode($responseJson, TRUE);

    if ($response['status'] == 'OK') {
      return $response;
    }

    return FALSE;
  }

  /**
   * Complet geocoding.
   *
   * @param $data
   *
   * @return string|mixed
   */
  public function geocode($data)
  {
    return $this->core('geocode/json', $data);
  }

  /**
   * Esay geocoding by address.
   *
   * @param $address
   *
   * @return string|mixed
   */
  public function geocodeByAddress($address)
  {
    return $this->core('geocode/json', [
      'address' => $address,
    ]);
  }

  /**
   * Esay geocoding.
   *
   * @param $address
   *
   * @return string|mixed
   */
  public function geocodeByLatLng($latlng, $lng = NULL)
  {
    if (! $lng) {
      $latlng = $this->latlngFormated($latlng, $lng);
    }

    return $this->core('geocode/json', [
      'latlng' => $latlng,
    ]);
  }

  /**
   * Class Core.
   *
   * @param $api
   * @param $data
   *
   * @return mixed
   */
  protected function core($api, $data)
  {
    return $this->CURL
      ->url($this->baseUrl($api))
      ->timeout(10)
      ->json()
      ->data(array_merge($data, [
        'language' => $this->countries[0],
        'key' => $this->key,
      ]))
      ->post();
  }

  /**
   * Get base Google Maps APi URL.
   *
   * @param string|null $next
   *
   * @return string
   */
  protected function baseUrl($next = NULL)
  {
    if ($next) {
      return "{$this->baseUrl}{$next}";
    }

    return $this->baseUrl;
  }

  /**
   * Format to string for google mpas latlng.
   *
   * @param $lat
   * @param $lng
   *
   * @return string
   */
  protected function latlngFormated($lat, $lng) {
    return number_format($lat, 7, '.', '') . ',' . number_format($lng, 7, '.', '');
  }

}