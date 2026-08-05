<?php

namespace App\Actions\Ticket;

class ShowTicketAction
{
    public function handle($ticket)
    {
        $ticket->load(['user', 'replies.user']);

        return $ticket;
    }
}
