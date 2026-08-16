<?php

namespace Modules\Ticket\Actions;

class ShowTicketAction
{
    public function handle($ticket)
    {
        $ticket->load(['user', 'replies.user']);

        return $ticket;
    }
}
