<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ticket;
use App\Http\Resources\Ticket as TicketResource;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Tickets
        $tickets = Ticket::orderBy('created_at', 'DESC')->paginate(5);
        // Return tickets as collection
        return TicketResource::collection($tickets);
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
        $ticket = $request->isMethod('put') ? Ticket::findOrFail($request->ticket_id) : new Ticket;

        $ticket->id = $request->input('ticket_id');
        $ticket->title = $request->input('title');
        $ticket->body = $request->input('body');

        if ($ticket->save()) {
            return new TicketResource($ticket);
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
        $ticket = Ticket::findOrFail($id);

        //Return single tcket as a reseource
        return new TicketResource($ticket);
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
        $ticket = Ticket::findOrFail($id);

        if ($ticket->delete()) {
            return new TicketResource($ticket);
        }   
    }
}
