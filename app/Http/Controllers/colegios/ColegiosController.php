<?php

namespace App\Http\Controllers\colegios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Tablas;

class ColegiosController extends Controller
{

    public function getColegios(){

        $colegios = Tablas::where("TACODI",46)->get();

        return  response()->json($colegios,200);

    }
}
