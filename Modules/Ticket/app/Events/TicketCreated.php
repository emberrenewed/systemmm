<?php

namespace Modules\Ticket\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Ticket\Models\Ticket;

class TicketCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Ticket $ticket)
    {
        $this->ticket->loadMissing('user');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admins'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ticket.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'status' => $this->ticket->status,
            'priority' => $this->ticket->priority,
            'created_at' => $this->ticket->created_at?->diffForHumans(),
            'user' => [
                'id' => $this->ticket->user->id,
                'name' => $this->ticket->user->name,
            ],
            'url' => url('/tickets/'.$this->ticket->id),
        ];
    }
}
