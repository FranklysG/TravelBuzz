<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Search;
use App\Models\Hotel;
use Illuminate\Http\Request;

/**
  *
  * Classe de busca de cordenadas e calculo de distância
  * @package DestinationController
  * @author Franklys Guimaraes <tunele095@gmail.com>
  * @copyright Franklys Guimaraes © 2021
  * @version 1.0
  */

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $orderby = $request->query('orderby');
        $itenPerPage = $request->query('itensPerPage');

        $destinations = Search::getNearbyHotels($lat, $lng, $orderby, $itenPerPage);
        
        $hotel = new Hotel;
        $prices = $hotel::where('price', '>', '0')->orderBy('price', 'asc')->get();
        return view('destination.index', [ 'destinations' =>  $destinations, 'prices' => $prices]);
    }

}
