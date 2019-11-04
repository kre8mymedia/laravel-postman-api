<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\Role;
use App\Http\Resources\Tenant as TenantResource;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get tenants
        $tenants = Tenant::orderBy('id', 'DESC')->paginate(5);
        // Return tenants as collection
        return TenantResource::collection($tenants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        // If method is put find Tenant by tenant_id else make new Tenant
        $tenant = $request->isMethod('put') ? Tenant::findOrFail($request->tenant_id) : new Tenant;
        // save request inputs to model properties
        $tenant->id = $request->input('tenant_id');
        $tenant->role_id = $request->input('role_id');

        if ($tenant->save()) {
            return new TenantResource($tenant);
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
        //Get single tenant
        $tenant = Tenant::findOrFail($id);

        //Return single tcket as a reseource
        return new TenantResource($tenant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete single tenant
        $tenant = Tenant::findOrFail($id);

        $role = Role::where('id', '=', $tenant->role_id)->first();
        $role->delete();

        if ($tenant->delete()) {
            return new TenantResource($tenant);
        }   
    }
}
