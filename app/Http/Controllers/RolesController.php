<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\User;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Roles
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        // Return roles as collection
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // If method is put find article by role_id else make new Role
        $role = $request->isMethod('put') ? Role::findOrFail($request->role_id) : new Role;

        $role->id = $request->input('role_id');
        $role->name = $request->input('name');
        $role->user_id = $request->input('user_id');

        if ($role->save()) {
            return new RoleResource($role);
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
        //Get single role
        $role = Role::findOrFail($id);

        //Return single tcket as a reseource
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete single role
        $role = Role::findOrFail($id);

        if ($role->delete()) {
            return new RoleResource($role);
        }   
    }
}