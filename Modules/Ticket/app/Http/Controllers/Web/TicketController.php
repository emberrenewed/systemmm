<?php

namespace Modules\Ticket\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Ticket\Actions\ListTicketsAction;
use Modules\Ticket\Actions\ShowTicketAction;
use Modules\Ticket\Actions\UpdateTicketStatusAction;
use Modules\Ticket\Http\Requests\IndexTicketRequest;
use Modules\Ticket\Http\Requests\ShowTicketRequest;
use Modules\Ticket\Http\Requests\UpdateTicketRequest;
use Modules\Ticket\Models\Ticket;

class TicketController extends Controller
{
    public function index(IndexTicketRequest $request, ListTicketsAction $action)
    {
        $tickets = $action->handle($request->user(), $request->validated());

        return view('ticket::index', ['tickets' => $tickets]);
    }

    public function show(ShowTicketRequest $request, Ticket $ticket, ShowTicketAction $action)
    {
        $ticket = $action->handle($ticket);

        return view('ticket::show', ['ticket' => $ticket]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket, UpdateTicketStatusAction $action)
    {
        $action->handle($ticket, $request->validated());

        return back()->with('success', 'Ticket updated successfully.');
    }
}
