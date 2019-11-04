<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Http\Resources\Property as PropertyResource;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Tickets
        $properties = Property::orderBy('created_at', 'DESC')->paginate(5);
        // Return tickets as collection
        return PropertyResource::collection($properties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If method is put find article by ticket_id else make new Ticket
        $property = $request->isMethod('put') ? Property::findOrFail($request->property_id) : new Property;

        $property->id = $request->input('property_id');
        $property->owner_id = $request->input('owner_id');
        $property->manager_id = $request->input('manager_id');
        $property->address = $request->input('address');

        if ($property->save()) {
            return new PropertyResource($property);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get single ticket
        $property = Ticket::findOrFail($id);

        //Return single tcket as a reseource
        return new PropertyResource($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get single ticket
        $property = Property::findOrFail($id);

        if ($property->delete()) {
            return new PropertyResource($property);
        }   
    }
}
