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
        // Get properties
        $properties = Property::orderBy('created_at', 'DESC')->paginate(5);
        // Return properties as collection
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

        // // Handle File Upload
        // if ($request->hasFile('image')) {
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('image')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just extension
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('image')->storeAs('public/property_images', $fileNameToStore); 
        // } else {
        //     // $fileNameToStore = 'noimage.jpg';
        //     return $request->all();
        // }

        // If method is put find article by property_id else make new Property
        $property = $request->isMethod('put') ? Property::findOrFail($request->property_id) : new Property;

        $property->id = $request->property_id;
        $property->owner_id = $request->owner_id;
        $property->manager_id = $request->manager_id;
        $property->address = $request->address;
        // $property->image = $fileNameToStore;
        $property->image = $request->image;

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
        //Get single property
        $property = Property::findOrFail($id);

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
        //Get single propertyow
        $property = Property::findOrFail($id);

        if ($property->delete()) {
            return new PropertyResource($property);
        }   
    }
}
