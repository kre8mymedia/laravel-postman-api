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