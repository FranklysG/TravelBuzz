<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
  *
  * @package Buzzvel
  * @author Franklys Guimaraes <tunele095@gmail.com>
  * @copyright Franklys Guimaraes © 2021
  * @version 1.0
  */

class Buzzvel{

  /**
   * Endpoint
   * @var string
  */
  protected $endpoint;
  
  /**
   * apikey access token of google patform
   * @var string
  */
  protected $apiKey;
  

  public function __construct(){
    $this->apiKey = $_ENV['GOOGLE_API_KEY'];
  }

  /**
   * Method responsible for returning the complete ENDPOINT of the request
   * @param string $endpoint endpoint name
   * @param array $params params
   * @param boolean $encode
   * @return string
   */
  public function getEndpoint($route = null, $params = array(), $encode = true){
    $this->endpoint = 'https://buzzvel-interviews.s3.eu-west-1.amazonaws.com';
    
    $endpoint = $this->endpoint;
    $apiKey = $this->apiKey;
    
    switch ($route) {
      default:
        $route = "/hotels.json";
        break;
    }

    $endpoint .= $route;

    return $endpoint;
  }

  /**
   * Method responsible for consuming the requested endpoints
   * @param string $endpoint endpoint name
   * @param string $type request method
   * @param array $params params of endpoint
   * @param array $data data sent in the request
   * @return array
   */
  public function send($type, $route = null, $params = array(), $data = array()){
    $endpoint = $this->getEndpoint($route, $params);
    switch ($type) {
      case 'get':
        $obResponse = Http::get($endpoint);
        break;
      case 'post':
        $obResponse = Http::post($endpoint, $data);
        break;
      case 'put':
        $obResponse = Http::put($endpoint, $data);
        break;
      case 'delete':
        $obResponse = Http::delete($endpoint, $data);
        break;
    }

    return ($obResponse->successful()) ? $obResponse->json() : false;
  }
}