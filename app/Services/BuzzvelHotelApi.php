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
   * @param string $endpoint nome do endpoint
   * @param array $params Parametros do endpoint
   * @param boolean $encode
   * @return string
   */
  private static function getEndpoint(string $endpoint, array $params = [], $encode = true){
    
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

      case 'distancematrix':
        $endpoint = "https://maps.googleapis.com/maps/api/distancematrix/json?language=pt-br&destinations={destinations}&origins={origins}&key=".$apiKey;
        break;
    }

    // Processa endpoint
    foreach ($params as $key => $value) {
      if ($encode) $value = rawurlencode($value); // converte para padrao de url
      $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
    }

    return $endpoint;
  }

  /**
   * Método responsável por consumir os endpoints solicitados
   * @param string $endpoint Nome do endpoint
   * @param string $type Tipo de requisição
   * @param array $params Parametros que compoem o endpoint
   * @param array $data Dados de envio para tipos de requisição como delete, put ou post
   * @return array
   */
  public static function send(string $endpoint, string $type, array $params = [], array $data = []){
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