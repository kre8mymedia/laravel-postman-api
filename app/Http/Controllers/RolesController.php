<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\User;
use App\Owner;
use App\Manager;
use App\Tenant;

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
        // Store inputs as variables
        $request_role_name = $request->input('name');
        $request_user_id = $request->input('user_id');

        // Check to see what the ROLE is, if not equal to strings return null
        if ($request_role_name == 'Owner') {
            $request_role_name = 'Owner';
        } elseif ($request_role_name == 'Manager') {
            $request_role_name = 'Manager';
        } elseif ($request_role_name == 'Tenant') {
            $request_role_name = 'Tenant';
        } else {
            $request_role_name = null;
        }
        
        // If method is put find Role by role_id else make new Role
        $role = $request->isMethod('put') ? Role::findOrFail($request->role_id) : new Role;
        // save request inputs to model properties
        $role->name = $request_role_name;
        $role->user_id = $request_user_id;
        $role->save();

        // Check if role->name and create new Model equal to the Role, create save variable for data
        if ($role->name == 'Owner') {
            $owner = new Owner;
            $owner->role_id = $role->id;
            $save = $owner->save();
        } elseif ($role->name == 'Manager') {
            $manager = new Manager;
            $manager->role_id = $role->id;
            $save = $manager->save();
        } elseif ($role->name == 'Tenant') {
            $tenant = new Tenant;
            $tenant->role_id = $role->id;
            $save = $tenant->save();
        }

        // if save variable received return payload
        if ($save) {
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

        if ($role->name == 'Owner') {
            $owner = Owner::where('role_id', '=', $role->id)->first();
            $owner->delete();
        } elseif ($role->name == 'Tenant') {
            $tenant = Tenant::where('role_id', '=', $role->id)->first();
            $tenant->delete();
        } elseif ($role->name == 'Manager') {
            $manager = Manager::where('role_id', '=', $role->id)->first();
            $manager->delete();
        }

        if ($role->delete()) {
            return new RoleResource($role);
        }   
    }
}