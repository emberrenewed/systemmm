<?php

namespace Modules\Ticket\Actions;

use Modules\Ticket\Models\Ticket;

class ListTicketsAction
{
    public function handle($user, $filters = [])
    {
        $query = Ticket::with('user');
        
        if (! $user->is_admin) {
            $query->where('user_id', $user->id);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->latest()->get();
    }
}
