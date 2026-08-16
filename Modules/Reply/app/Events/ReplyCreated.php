<?php

namespace Modules\Reply\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Reply\Models\Reply;

class ReplyCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Reply $reply)
    {
        $this->reply->loadMissing('user');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('tickets.'.$this->reply->ticket_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'reply.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->reply->id,
            'ticket_id' => $this->reply->ticket_id,
            'message' => $this->reply->message,
            'image_url' => $this->reply->imageUrl(),
            'user' => [
                'id' => $this->reply->user->id,
                'name' => $this->reply->user->name,
                'is_admin' => $this->reply->user->is_admin,
            ],
            'created_at' => $this->reply->created_at?->toISOString(),
        ];
    }
}
