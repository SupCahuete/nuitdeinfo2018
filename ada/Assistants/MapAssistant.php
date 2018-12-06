<?php

namespace Ada\Assistants;

use AdaCurl;

class MapAssistant
{
  /**
   * Return the towns on the zipcode.
   *
   * @param integer $code
   *
   * @return \stdClass
   */
  function zipcode($code) {
    return json_decode(AdaCurl::get("http://vicopo.selfbuild.fr/code/$code"));
  }

  /**
   * Return the zipcodes on the town.
   *
   * @param integer $town
   *
   * @return \stdClass
   */
  function town($town) {
    $town = urlencode($town);
    return json_decode(AdaCurl::get("http://vicopo.selfbuild.fr/city/$town"));
  }

  /**
   * Return the towns on the zipcode of the array format.
   *
   * @param integer $code
   *
   * @return \stdClass
   */
  function zipcodeArray($code) {
    return json_decode(AdaCurl::get("http://vicopo.selfbuild.fr/code/$code"), TRUE);
  }

  /**
   * Return the zipcodes on the town of the array format.
   *
   * @param integer $town
   *
   * @return \stdClass
   */
  function townArray($town) {
    $town = urlencode($town);
    return json_decode(AdaCurl::get("http://vicopo.selfbuild.fr/city/$town"), TRUE);
  }
}