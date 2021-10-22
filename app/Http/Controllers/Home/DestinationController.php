<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
