<?php

namespace Modules\Ticket\Actions;

use Modules\Ticket\Events\TicketCreated;
use Modules\Ticket\Models\Ticket;

class CreateTicketAction
{
    public function handle($user, $data)
    {
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => $data['subject'],
            'description' => $data['description'],
        ]);

        $ticket->load('user');
       // TicketCreated::dispatch($ticket);
        rescue(fn()=>event(new TicketCreated($ticket)));
        return $ticket;
    }
}