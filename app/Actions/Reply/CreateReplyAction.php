<?php

namespace App\Actions\Reply;

use App\Models\Reply;

class CreateReplyAction
{
    public function handle($user, $ticket, $data)
    {
        $reply = Reply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $data['message'],
        ]);

        if ($ticket->status === 'open') {
            $ticket->update([
                'status' => 'in_progress',
            ]);
        }

        $reply->load('user');

        return [
            'reply' => $reply,
            'ticket_status' => $ticket->fresh()->status,
        ];
    }
}
