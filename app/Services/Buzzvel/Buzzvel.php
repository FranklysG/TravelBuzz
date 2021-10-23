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
   * apikey token de acesso a google patform
   * @var string
  */
  protected $apiKey;
  

  public function __construct(){
    $this->apiKey = $_ENV['GOOGLE_API_KEY'];
  }

  /**
   * Método repsonsavel por retornar o ENDPOINT completo da requisição
   * @param string $endpoint nome do endpoint
   * @param array $params parametros 
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

    // process endpoint
    foreach ($params as $key => $value) {
      if ($encode) $value = rawurlencode($value);
      $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
    }

    return $endpoint;
  }

  /**
   * Método responsável por consumir os endpoints solicitados
   * @param string $endpoint nome do endpoint 
   * @param string $type metodo da requisição
   * @param array $params parametros para o endpoint
   * @param array $data dados enviados na requisição
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