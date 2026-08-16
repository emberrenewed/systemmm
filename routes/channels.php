<?php

use Illuminate\Support\Facades\Broadcast;
use Modules\Ticket\Models\Ticket;

Broadcast::channel('admins', function ($user) 
{
    return (bool) $user->is_admin;
});
Broadcast::channel('tickets.{ticketId}',function ($user, $ticketId) {
        $ticket = Ticket::find($ticketId);
        if (! $ticket) {
            return false;
        }
        return $user->is_admin || (int) $ticket->user_id === (int) $user->id;
    });