<?php

namespace Modules\Ticket\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Ticket\Actions\CreateTicketAction;
use Modules\Ticket\Actions\DeleteTicketAction;
use Modules\Ticket\Actions\ListTicketsAction;
use Modules\Ticket\Actions\ShowTicketAction;
use Modules\Ticket\Actions\UpdateTicketStatusAction;
use Modules\Ticket\Http\Requests\DeleteTicketRequest;
use Modules\Ticket\Http\Requests\IndexTicketRequest;
use Modules\Ticket\Http\Requests\ShowTicketRequest;
use Modules\Ticket\Http\Requests\StoreTicketRequest;
use Modules\Ticket\Http\Requests\UpdateTicketRequest;
use Modules\Ticket\Http\Resources\TicketResource;
use Modules\Ticket\Models\Ticket;

class TicketController extends Controller
{
    public function index(IndexTicketRequest $request, ListTicketsAction $action)
    {
        $tickets = $action->handle($request->user(),
            $request->only(['status', 'priority']));

        return TicketResource::collection($tickets);
    }

    public function store(StoreTicketRequest $request, CreateTicketAction $action)
    {
        $ticket = $action->handle($request->user(), $request->validated());

        return TicketResource::make($ticket)->additional(['message' => (__('messages.ticket_created'))])->response()->setStatusCode(201);
    }

    public function show(ShowTicketRequest $request, Ticket $ticket, ShowTicketAction $action)
    {
        $ticket = $action->handle($ticket);

        return TicketResource::make($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket, UpdateTicketStatusAction $action)
    {
        $ticket = $action->handle($ticket, $request->validated());

        return TicketResource::make($ticket)->additional(['message' => (__('messages.ticket_status_updated'))])->response()->setStatusCode(200);
    }

    public function destroy(DeleteTicketRequest $request, Ticket $ticket, DeleteTicketAction $action)
    {
        $action->handle($ticket);

        return response()->json(['message' => (__('messages.ticket_deleted'))]);
    }
}
