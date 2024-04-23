<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Models\Registro;
use App\Models\Ocorrencia;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
        return view('places.index',[
            'places' => Place::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin');
        return view('places.create');
    }

    public function store(PlaceRequest $request)
    {
        $this->authorize('admin');
        $place = new Place;
        $place->name = $request->name;
        $place->save();
        
        return redirect('/places');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $this->authorize('admin');
        $place = Place::find($id);
        return view('places.create',['places' => $place]);
    }

    public function update(PlaceRequest $request, Place $place)
    {
        $this->authorize('admin');
        $place = Place::find($request->place_id);
        $place->name = $request->name;
        $place->update();
        
        return redirect('/places');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
