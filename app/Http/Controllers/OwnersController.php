<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use App\Http\Resources\Owner as OwnerResource;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get owners
        $owners = Owner::orderBy('id', 'DESC')->paginate(5);
        // Return owners as collection
        return OwnerResource::collection($owners);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        // If method is put find Owner by owner_id else make new Owner
        $owner = $request->isMethod('put') ? Owner::findOrFail($request->owner_id) : new Owner;
        // save request inputs to model properties
        $owner->id = $request->input('owner_id');
        $owner->role_id = $request->input('role_id');

        if ($owner->save()) {
            return new OwnerResource($owner);
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
        //Get single owner
        $owner = Owner::findOrFail($id);

        //Return single tcket as a reseource
        return new OwnerResource($owner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete single owner
        $owner = Owner::findOrFail($id);

        if ($owner->delete()) {
            return new OwnerResource($owner);
        }   
    }
}