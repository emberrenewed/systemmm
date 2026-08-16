<?php

namespace Modules\Ticket\Actions;

class UpdateTicketStatusAction
{
    public function handle($ticket, $data)
    {
        $ticket->update($data);

        $ticket->load('user');

        return $ticket;
    }
}
