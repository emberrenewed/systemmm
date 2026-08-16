<?php

namespace Modules\Reply\Actions;

use Modules\Reply\Events\ReplyCreated;
use Modules\Reply\Models\Reply;

class CreateReplyAction
{
    public function handle($user, $ticket, $data)
    {
        $imagePath = null;

        if (! empty($data['image'])) {
            $imagePath = $data['image']->store('replies', 'public');
        }

        $reply = Reply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $data['message'],
            'image' => $imagePath,
        ]);

        if (in_array($ticket->status, ['open', null], true)) {
            $ticket->update([
                'status' => 'in_progress',
            ]);
        }

        $reply->load('user');

        
        rescue(fn () => event(new ReplyCreated($reply)));

        
        return [
            'reply' => $reply,
            'ticket_status' => $ticket->fresh()->status,
        ];
    }
}
