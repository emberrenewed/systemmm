<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\CreateTicketAction;
use App\Actions\Ticket\DeleteTicketAction;
use App\Actions\Ticket\ListTicketsAction;
use App\Actions\Ticket\ShowTicketAction;
use App\Actions\Ticket\UpdateTicketStatusAction;
use App\Http\Requests\Ticket\DeleteTicketRequest;
use App\Http\Requests\Ticket\IndexTicketRequest;
use App\Http\Requests\Ticket\ShowTicketRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketController extends Controller
{
    //index
    public function index(IndexTicketRequest $request, ListTicketsAction $action)
    {   
    
            $tickets = $action->handle($request->user(),
            $request->only(['status', 'priority']));
        return TicketResource::collection($tickets);
    }
    //store  
    public function store(StoreTicketRequest $request, CreateTicketAction $action)
    {
        $ticket = $action->handle($request->user(), $request->validated());
        return TicketResource::make($ticket)->additional(['message' => 'Ticket created successfully.'])->response()->setStatusCode(201);
    }
    //show
    public function show(ShowTicketRequest $request, Ticket $ticket, ShowTicketAction $action)
    {
        $ticket = $action->handle($ticket);
        return TicketResource::make($ticket);
    }
    //update
    public function update(UpdateTicketRequest $request, Ticket $ticket, UpdateTicketStatusAction $action)
    {
        $ticket = $action->handle($ticket, $request->validated());
        return TicketResource::make($ticket)->additional(['message' => 'Ticket status updated successfully.']);
    }
    //delete
    public function destroy(DeleteTicketRequest $request, Ticket $ticket, DeleteTicketAction $action)
    {
        $action->handle($ticket);
        return response()->json(['message' => 'Ticket deleted successfully.',]);
    }
}