<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
  *
  * Classe de busca de cordenadas e calculo de distância
  * @package BuzzvelHotelApi
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
    public function index()
    {
        return view('destination.index');
    }

    /**
     * Method respose for refaund this objects of destinations
     * @param $var
     * @return mixed view
     */
    public function show($slug)
    {
        return view('destination.show', [ 'slug' => $slug]);
    }
}
