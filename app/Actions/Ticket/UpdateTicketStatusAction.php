<?php

namespace App\Actions\Ticket;

class UpdateTicketStatusAction
{
    public function handle($ticket, $data)
    {
        $ticket->update($data);

        $ticket->load('user');

        return $ticket;
    }
}
