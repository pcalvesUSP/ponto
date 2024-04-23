<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;
use Auth;
use App\Models\Grupo;

class IndexController extends Controller
{
    public function index()
    {   
        if (strpos($_SERVER['REMOTE_ADDR'],'107.6') === false && strpos($_SERVER['REMOTE_ADDR'],'107.7') === false && strpos($_SERVER['REMOTE_ADDR'],'107.9') === false) {
            return "<script> alert('Equipamento não autorizado ".$_SERVER['REMOTE_ADDR']."'); window.location = 'https://www.fcf.usp.br'; </script>";
        }
        
        if (Auth::check()) {
            $places = Place::all();
        } else {
            $places = Place::where('name', 'like', '%pro-aluno%')->orWhere('name', 'like', '%proaluno%')->get();
        }
        return view('index',[
            'places' => $places,
        ]);
    }
}
