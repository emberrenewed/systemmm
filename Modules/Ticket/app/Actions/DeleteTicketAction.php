<?php

namespace Modules\Ticket\Actions;

class DeleteTicketAction
{
    public function handle($ticket)
    {
        $ticket->delete();
    }
}
