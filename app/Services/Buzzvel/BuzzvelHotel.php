<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Buzzvel;
use App\Services\Google;
use App\Models\Hotel;

/**
  *
  * @package BuzzvelHotel
  * @author Franklys Guimaraes <tunele095@gmail.com>
  * @copyright Franklys Guimaraes © 2021
  * @version 1.0
  */

class BuzzvelHotel extends Buzzvel{

    /**
   * Run the database seeds.
   * Metodo resposavel por carregar todos os hoteis da api em banco 
   * a fim de otimizar a consulta 
   * @return void
   */
    public static function searchHotelList(){
        $buzzvel = new Buzzvel;
        $data = $buzzvel->send('get','buzzvel');
        if(!isset($data['message']) and empty($data['message'])) return false;
        self::deparaHotelList($data['message']);
    }
    
    /**
   * Run the database seeds.
   * Metodo resposavel tratar os dados recebidos via api 
   * a fim de otimizar a consulta 
   * @param array $data todos os dados recuperados da api
   * @return void
   */
    public function deparaHotelList($data){
        
        foreach($data as $key => $value){
            if (!strlen($value[1]) or !strlen($value[2])) continue;
            $address = [
                'address' => $value[0],
                'lat' => $value[1],
                'lng' => $value[2],
                'price' => $value[3],
            ];
            $complements = self::getAddressLocation($value[1], $value[2]);
            $register = array_merge($complements, $address);

            self::store([
                $register
            ]);
        }

    }
    
    /**
   * Run the database seeds.
   * Metodo resposavel tratar os dados recebidos via api 
   * a fim de otimizar a consulta 
   * @param string $lat latitude
   * @param string $lng longitude
   * @return void
   */
    public function getAddressLocation($lat, $lng){
        $google = new Google;
        $data = $google->send('get','geocode', ['latlng' => $lat.','.$lng]);
        
        if(!isset($data['results']) and empty($data['results'])) {
            return $return = [
                'country' => 'Invalide Country',
                'state' => 'Invalide State',
                'city' => 'Invalide City'
            ];
        }

        $object = $data['results'];
        $return = [
            'country' => $object[0]['address_components'][5]['long_name'] ?? 'Invalide Country',
            'state' => $object[0]['address_components'][4]['long_name']  ?? 'Invalide State',
            'city' => $object[0]['address_components'][3]['long_name']  ?? 'Invalide City'
        ];

        return $return;
    }

    /**
   * Run the database seeds.
   * Metodo resposavel por salvar todos os hoteis da api em banco 
   * a fim de otimizar a consulta 
   * @return void
   */
    public static function store($data = array()){
        // dd($data);
        $ob = new Hotel;
        $ob->create($data[0]);
    }

}