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
   * Method responsible for returning a list of hotels near the location informed
   * @param string $lat Desired parameters "latitude"
   * @param string $lng Desired parameters "longitude"
   * @param string $orderby Desired parameters “proximity” or “pricepernight”  
   * @return array
   */
  public static function getNearbyHotels($lat, $lng, $orderby = 'proximity', $itensPerPage = '10'){
    // get hotels
    $hotels = self::getHotels($lat, $lng, $itensPerPage);
    $hotels = self::orderHotels($hotels, $lat, $lng, $orderby);

    return $hotels;
  }

  /**
   * Method responsible for merging the data saved in the database with the distance between the points
   * @param string $lat latitude
   * @param string $lng longitude
   * @return void
   */
  public function getHotels($lat, $lng, $itensPerPage){
    $hotels = Hotel::limit($itensPerPage)->get();
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

   /**
   * Method responsible for ordering the hotels according to the requested "price" or "proximity"
   * @param array $hotel all intes hotel
   * @param string $latitude latitude
   * @param string $longitude longitude
   * @param string $orderBy orderBy sort by "proximity" or by "price"
   * @return void
   */
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

   /**
   * Method responsible for calculating the distance in km or in miles
   * @param string $latOrigin latitude of Origin
   * @param string $lngOrigin longitude of Origin
   * @param string $latDestinations latitude of Destinations
   * @param string $lngDestinations longitude of Destinations
   * @return void
   */
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