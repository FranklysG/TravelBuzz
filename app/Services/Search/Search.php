<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Google;
use App\Models\Hotel;

/**
  *
  * @package Search
  * @author Franklys Guimaraes <tunele095@gmail.com>
  * @copyright Franklys Guimaraes © 2021
  * @version 1.0
  */

class Search extends Google{


   /**
   * Método responsável por retornar uma listagem de hoteis próximos ao local informado
   * @param string $lat
   * @param string $lng
   * @param string $orderby Desired parameters “proximity” or “pricepernight”  
   * @return array
   */
  public static function getNearbyHotels($lat, $lng, $orderby = 'proximity'){
    // get hotels
    $hotels = self::getHotels($lat, $lng);
    $hotels = self::orderHotels($hotels, $lat, $lng, $orderby);

    return $hotels;
  }

  /**
   * Run the database seeds.
   * Metodo resposavel tratar os dados recebidos via api 
   * a fim de otimizar a consulta 
   * @param string $lat latitude
   * @param string $lng longitude
   * @return void
   */
  public function getHotels($lat, $lng){
    $hotels = Hotel::all();
    $destinations = array();
    foreach($hotels as $hotel){
      $distance = self::getDistanceHotels($lat, $lng, $hotel->lat, $hotel->lng);
      $destinations[] = [
        'price' => $hotel->price,
        'address' => $hotel->address,
        'country' => $hotel->country,
        'address' => $hotel->address,
        'lat' => $hotel->lat,
        'lng' => $hotel->lng,
        'distance' => round($distance)
      ];
    }

    return $destinations;
  }

  //order hotels
  public static function orderHotels( $hotels, $latitude, $longitude, $orderBy )
  {
      $orderBy = isset($orderBy) && !empty($orderBy) ? $orderBy : "proximity";
      if( $orderBy == 'proximity' ) {
          // sort array by distance
          usort($hotels, function($latDestinationMax, $latDestinationMin) use ($latitude, $longitude) {
              $latDestinationMax = self::getDistanceHotels($latitude, $longitude, $latDestinationMax['lat'], $latDestinationMax['lng']);
              $latDestinationMin = self::getDistanceHotels($latitude, $longitude, $latDestinationMin['lat'], $latDestinationMin['lng']);
              if ($latDestinationMax == $latDestinationMin) {
                  return 0;
              }
              return ($latDestinationMax < $latDestinationMin) ? -1 : 1;
          });
      } else if( $orderBy == 'price' ) {
          // sort array by price per night
          usort($hotels, function($priceMax, $priceMin) {
              if ($priceMax['price'] == $priceMin['price']) {
                  return 0;
              }
              return ($priceMax['price'] < $priceMin['price']) ? -1 : 1;
          });
      }
      return $hotels;
  }

  // Calculate distance between two points in latitude and longitude in km's or miles
  public static function getDistanceHotels($latOrigin,$lngOrigin,$latDestination,$lngDestination){
      $latOrigin = floatval($latOrigin);
      $lngOrigin = floatval($lngOrigin);
      $latDestination = floatval($latDestination);
      $lngDestination = floatval($lngDestination);

      $pi80 = M_PI / 180;
      $latOrigin *= $pi80;
      $lngOrigin *= $pi80;
      $latDestination *= $pi80;
      $lngDestination *= $pi80;

      $radiusEath = 6372.797; // mean radius of Earth in km
      $dlat = $latDestination - $latOrigin;
      $dlon = $lngDestination - $lngOrigin;

      $a = sin($dlat / 2) * sin($dlat / 2) + cos($latOrigin) * cos($latDestination) * sin($dlon / 2) * sin($dlon / 2);
      $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
      $distance = $radiusEath * $c;
      
      return $distance;
  }

}