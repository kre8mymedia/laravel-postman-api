<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use App\Http\Resources\Manager as ManagerResource;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get managers
        $managers = Manager::orderBy('id', 'DESC')->paginate(5);
        // Return managers as collection
        return ManagerResource::collection($managers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        // If method is put find Manager by manager_id else make new Manager
        $manager = $request->isMethod('put') ? Manager::findOrFail($request->manager_id) : new Manager;
        // save request inputs to model properties
        $manager->id = $request->input('manager_id');
        $manager->role_id = $request->input('role_id');

        if ($manager->save()) {
            return new ManagerResource($manager);
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
        //Get single manager
        $manager = Manager::findOrFail($id);

        //Return single tcket as a reseource
        return new ManagerResource($manager);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete single manager
        $manager = Manager::findOrFail($id);

        if ($manager->delete()) {
            return new ManagerResource($manager);
        }   
    }
}