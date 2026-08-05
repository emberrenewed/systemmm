<?php

namespace App\Actions\Reply;

class DeleteReplyAction
{
    public function handle($reply)
    {
        $reply->delete();
    }
}
