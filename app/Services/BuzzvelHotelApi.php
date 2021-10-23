<?php

namespace App\Services;

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Http;

/**
  *
  * Classe de busca de cordenadas e calculo de distância
  * @package BuzzvelHotelApi
  * @author Franklys Guimaraes <tunele095@gmail.com>
  * @copyright Franklys Guimaraes © 2021
  * @version 1.0
  */

class BuzzvelHotelApi{

  
/**
   * Método responsavel por processar e retornar o enpoint solicitado
   * @param string $endpoint the endpoint name
   * @param array $params the endpoint params
   * @param boolean $encode
   * @return string
   */
  private static function getEndpoint($endpoint, $params = [], $encode = true){
    
    $apiKey = $_ENV['API_KEY'];
    switch ($endpoint) {
      case 'buzzvel-hotels':
        $endpoint = "https://buzzvel-interviews.s3.eu-west-1.amazonaws.com/hotels.json";
        break;

      case 'geocode':
        $endpoint = "https://maps.googleapis.com/maps/api/geocode/json?language=pt-br&latlng={latlng}&key=".$apiKey;
        break;

      case 'geocode-address':
        $endpoint = "https://maps.googleapis.com/maps/api/geocode/json?language=pt-br&address={address}&key=".$apiKey;
        break;
    }

    // process endpoint
    foreach ($params as $key => $value) {
      if ($encode) $value = rawurlencode($value);
      $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
    }

    return $endpoint;
  }

  /**
   * Método responsável por consumir os endpoints solicitados
   * @param string $endpoint the endpoint name 
   * @param string $type request method
   * @param array $params param the endpoint
   * @param array $data submission data for request types such as delete, put or post
   * @return array
   */
  public static function send($endpoint, $type, $params = [], $data = []){
    $endpoint = self::getEndpoint($endpoint, $params);
    
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