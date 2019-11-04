<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// LIST Tickets
Route::get('tickets', 'TicketsController@index');
// SINGLE Ticket
Route::get('ticket/{id}', 'TicketsController@show');
// CREATE Ticket
Route::post('ticket', 'TicketsController@store');
// UPDATE Ticket
Route::put('ticket', 'TicketsController@store');
// DELETE Ticket
Route::delete('ticket/{id}', 'TicketsController@destroy');

// ----------------------------------------------------------------

// LIST Users
Route::get('users', 'UsersController@index');
// SINGLE User
Route::get('user/{id}', 'UsersController@show');
// CREATE User
Route::post('user', 'UsersController@store');
// UPDATE User
Route::put('user', 'UsersController@store');
// DELETE User
Route::delete('user/{id}', 'UsersController@destroy');

// ----------------------------------------------------------------

// LIST Roles
Route::get('roles', 'RolesController@index');
// SINGLE Role
Route::get('role/{id}', 'RolesController@show');
// CREATE Role
Route::post('role', 'RolesController@store');
// UPDATE Role
Route::put('role', 'RolesController@store');
// DELETE Role
Route::delete('role/{id}', 'RolesController@destroy');

// ----------------------------------------------------------------

// LIST Owners
Route::get('owners', 'OwnersController@index');
// SINGLE Owner
Route::get('owner/{id}', 'OwnersController@show');
// CREATE Owner
Route::post('owner', 'OwnersController@store');
// UPDATE Owner
Route::put('owner', 'OwnersController@store');
// DELETE Owner
Route::delete('owner/{id}', 'OwnersController@destroy');

// ----------------------------------------------------------------

// LIST Managers
Route::get('managers', 'ManagersController@index');
// SINGLE Manager
Route::get('manager/{id}', 'ManagersController@show');
// CREATE Manager
Route::post('manager', 'ManagersController@store');
// UPDATE Manager
Route::put('manager', 'ManagersController@store');
// DELETE Manager
Route::delete('manager/{id}', 'ManagersController@destroy');

// ----------------------------------------------------------------

// LIST Tenants
Route::get('tenants', 'TenantsController@index');
// SINGLE Tenant
Route::get('tenant/{id}', 'TenantsController@show');
// CREATE Tenant
Route::post('tenant', 'TenantsController@store');
// UPDATE Tenant
Route::put('tenant', 'TenantsController@store');
// DELETE Tenant
Route::delete('tenant/{id}', 'TenantsController@destroy');