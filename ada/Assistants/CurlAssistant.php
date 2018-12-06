<?php

namespace Ada\Assistants;

use stdClass;
use File;

/*
 * Based on Ixudra\Curl package - @https://github.com/ixudra/curl
 */
class CurlAssistant {

  /**
   * cURL request
   *
   * @var resource $curlObject
   */
  protected $curlObject = NULL;

  /**
   * Array of cURL options.
   *
   * @var array $curlOptions
   */
  protected $curlOptions = [
    'RETURNTRANSFER'        => TRUE,
    'FAILONERROR'           => FALSE,
    'FOLLOWLOCATION'        => FALSE,
    'CONNECTTIMEOUT'        => '',
    'TIMEOUT'               => 30,
    'USERAGENT'             => '',
    'URL'                   => '',
    'POST'                  => FALSE,
    'HTTPHEADER'            => [],
    'SSL_VERIFYPEER'        => TRUE,
  ];

  /**
   * Array with options that are not specific to cURL but are used by the package.
   *
   * @var array $packageOptions
   */
  protected $packageOptions = [
    'data'                  => FALSE,
    'jsonRequest'           => FALSE,
    'jsonResponse'          => FALSE,
    'jsonTypeReturn'        => FALSE,
    'info'                  => FALSE,
    'debug'                 => FALSE,
    'containsFile'          => FALSE,
    'download'              => FALSE,
  ];
  
  /**
   * Set the URL to which the request is to be sent.
   *
   * @param $url string    The URL to which the request is to be sent.
   *
   * @return self
   */
  public function url($url)
  {
    $this->curlOptions['URL'] = $url;

    return $this;
  }

  /**
   * Disable verification on ssl connection.
   *
   * @return self
   */
  public function notSecure()
  {
    $this->curlOptions['SSL_VERIFYPEER'] = FALSE;

    return $this;
  }

  /**
   * Allow for redirects in the request
   *
   * @return self
   */
  public function allowRedirect()
  {
    $this->curlOptions['FOLLOWLOCATION'] = TRUE;

    return $this;
  }

  /**
   * Set the request timeout.
   *
   * @param integer $timeout    The timeout for the request (in seconds. Default: 30 seconds).
   *
   * @return self
   */
  public function timeout($timeout = 30)
  {
    $this->curlOptions['TIMEOUT'] = $timeout;

    return $this;
  }

  /**
   * Add GET or POST data to the request.
   *
   * @param array $data    Array of data that is to be sent along with the request.
   *
   * @return self
   */
  public function data($data = [])
  {
    $this->packageOptions['data'] = $data;

    return $this;
  }
  public function query($data = []) // data method's alias.
  {
    $this->packageOptions['data'] =  $data;

    return $this;
  }

  /**
   * Enable File sending.
   *
   * @return self
   */
  public function containsFile()
  {
    $this->packageOptions['containsFile'] = TRUE;

    return $this;
  }

  /**
   * Send a download request to a URL using the specified cURL options.
   *
   * @param string $fileName
   *
   * @return mixed
   */
  public function download($fileName)
  {
    $this->packageOptions['download'] = $fileName;

    return $this->send();
  }

  /**
   * Enable debug mode for the cURL request.
   *
   * @param string $logFile    The full path to the log file you want to use.
   *
   * @return self
   */
  public function debug($logFile)
  {
    $this->packageOptions['debug'] = $logFile;

    $this->curlOptions['VERBOSE'] = TRUE;

    return $this;
  }

  /**
   * Set Cookie File.
   *
   * @param string $cookieFile    File name to read cookies from.
   *
   * @return self
   */
  public function setCookieFile($cookieFile)
  {
    $this->curlOptions['COOKIEFILE'] = $cookieFile;

    return $this;
  }

  /**
   * Set Cookie Jar
   *
   * @param string $cookieJar    File name to store cookies to.
   *
   * @return self
   */
  public function setCookieJar($cookieJar)
  {
    $this->curlOptions['COOKIEJAR'] = $cookieJar;

    return $this;
  }

  /**
   * Add a HTTP header to the request.
   *
   * @param string|array $header    The HTTP header that is to be added to the request.
   *
   * @return self
   */
  public function header($header)
  {
    if (is_array($header)) {
      $this->curlOptions['HTTPHEADER'] = $header;
    }
    else {
      $this->curlOptions['HTTPHEADER'] = [$header];
    }

    return $this;
  }

  /**
   * Add a content type HTTP header to the request.
   *
   * @param string $contentType    The content type of the file you would like to download.
   *
   * @return self
   */
  public function contentType($contentType)
  {
    return $this->header('Content-Type: '. $contentType)
                ->header('Connection: Keep-Alive');
  }

  /**
   * Configure the package to encode and decode the request data.
   *
   * @param boolean $arrayReturn    Indicates whether or not the data should be returned as an array. Default: TURE.
   *
   * @return self
   */
  public function json($arrayReturn = TRUE)
  {
    return $this->jsonRequest()
                ->jsonResponse($arrayReturn);
  }

  /**
   * Configure the package to encode the request data to json before sending it to the server.
   *
   * @return self
   */
  public function jsonRequest()
  {
    $this->packageOptions['jsonRequest'] = TRUE;

    return $this;
  }

  /**
   * Configure the package to decode the request data from json to object or associative array.
   *
   * @param boolean $arrayReturn   Indicates whether or not the data should be returned as an array. Default: TURE.
   *
   * @return self
   */
  public function jsonResponse($arrayReturn = TRUE)
  {
    $this->packageOptions['jsonResponse'] = TRUE;

    $this->packageOptions['jsonTypeReturn'] = $arrayReturn;

    return $this;
  }

  /**
   * Return a full response object with HTTP status and headers instead of only the content.
   *
   * @return self
   */
  public function info()
  {
    $this->packageOptions['info'] = TRUE;

    return $this;
  }

  /**
   * Send a GET request to a URL using the specified cURL options.
   *
   * @param $url string
   *
   * @return mixed
   */
  public function get($url = NULL)
  {
    if ($url) $this->url($url);

    $this->setDataURL();

    return $this->send();
  }

  /**
   * Send a POST request to a URL using the specified cURL options.
   *
   * @param $url string
   *
   * @return mixed
   */
  public function post($url = NULL)
  {
    if ($url) $this->url($url);

    $this->setPostParameters();

    return $this->send();
  }

  /**
   * Send a PUT request to a URL using the specified cURL options.
   *
   * @param $url string
   *
   * @return mixed
   */
  public function put($url = NULL)
  {
    if ($url) $this->url($url);

    $this->setPostParameters();

    $this->curlOptions['CUSTOMREQUEST'] = 'PUT';

    return $this->send();
  }

  /**
   * Send a PATCH request to a URL using the specified cURL options.
   *
   * @param $url string
   *
   * @return mixed
   */
  public function patch($url = NULL)
  {
    if ($url) $this->url($url);

    $this->setPostParameters();

    $ $this->curlOptions['CUSTOMREQUEST'] = 'PATCH';

    return $this->send();
  }

  /**
   * Send a DELETE request to a URL using the specified cURL options.
   *
   * @param $url string
   *
   * @return mixed
   */
  public function delete($url = NULL)
  {
    if ($url) $this->url($url);

    $this->setDataURL();

    $this->curlOptions['CUSTOMREQUEST'] = 'DELETE';

    return $this->send();
  }

  /**
   * Append set data to the query string for GET and DELETE cURL requests.
   *
   * @return void
   */
  protected function setDataURL()
  {
    if (is_array($this->packageOptions['data']) && count($this->packageOptions['data']) != 0) {
      $this->curlOptions['URL'] .= '?'. http_build_query($this->packageOptions['data'], NULL, '&');
    }
  }

  /**
   * Add POST parameters to the curlOptions array.
   *
   * @return void
   */
  protected function setPostParameters()
  {
    $this->curlOptions['POST'] = TRUE;

    $parameters = $this->packageOptions['jsonRequest'] ?
      json_encode($this->packageOptions['data']) :
      $this->packageOptions['data'];

    $this->curlOptions['POSTFIELDS'] = $parameters;
  }

  /**
   * Send the request.
   *
   * @return mixed
   */
  protected function send()
  {
    // Add JSON header if necessary.
    if ($this->packageOptions['jsonRequest']) {
      $this->header('Content-Type: application/json');
    }

    if ($debugFile = $this->packageOptions['debug']) {
      $debugFile = fopen($debugFile, 'w');
      $this->curlOptions['STDERR'] = $debugFile;
    }

    // Create the request with all specified options.
    $cURL = curl_init();
    curl_setopt_array($cURL, $this->forgeOptions());

    // Send the request.
    $response = curl_exec($cURL);

    // Additional request's information if info() si used.
    $info = NULL;
    if ($this->packageOptions['info']) {
      $info = curl_getinfo($cURL);

      if (curl_errno($cURL)) {
        $info['error_message'] = curl_error($cURL);
      }
    }

    // Close the curl instance.
    curl_close($cURL);

    // Close the file debug if debug() is used.
    if ($this->packageOptions['debug']) {
      fclose($debugFile);
    }

    if ($filePath = $this->packageOptions['download']) {
      File::put($filePath, $response);
    } 
    else if ($this->packageOptions['jsonResponse']) {
      // Decode the request if necessary.
      $response = json_decode($response, $this->packageOptions['jsonTypeReturn']);
    }

    // Return the result
    return $this->returnResponse($response, $info);
  }

  /**
   * Convert the curlOptions to an array of usable options for the cURL request.
   *
   * @return array
   */
  protected function forgeOptions()
  {
    $results = [];

    foreach($this->curlOptions as $key => $value) {
      $arrayKey = constant('CURLOPT_' . $key);

      if (! $this->packageOptions['containsFile'] && $key == 'POSTFIELDS' && is_array($value)) {
        $results[$arrayKey] = http_build_query($value, NULL, '&');
      }
      else {
        $results[$arrayKey] = $value;
      }
    }

    return $results;
  }

  /**
   * Return a response of the curl request.
   *
   * @param mixed $content    Content of the request.
   * @param array $info    Additional response information.
   *
   * @return string|stdClass
   */
  protected function returnResponse($content, $info)
  {
    if (! $this->packageOptions['info']) {
      return $content;
    }

    $object = new stdClass();
    $object->info = $info;
    $object->content = $content;
    $object->status = $info['http_code'];
    if (array_key_exists('error_message', $info)) {
      $object->error = $info['error_message'];
    }
    else {
      $object->error = FALSE;
    }

    return $object;
  }
}
