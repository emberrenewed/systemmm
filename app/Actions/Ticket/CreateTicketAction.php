<?php

namespace App\Actions\Ticket;

use App\Models\Ticket;

class CreateTicketAction
{



    public function handle($user, $data)
    {
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?? 'medium',
            'status' => 'open',
        ]);

        $ticket->load('user');

        return $ticket;
    }
    
}
