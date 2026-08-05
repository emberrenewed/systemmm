<?php

namespace App\Actions\Ticket;

class DeleteTicketAction
{
    public function handle($ticket)
    {
        $ticket->delete();
    }
}
