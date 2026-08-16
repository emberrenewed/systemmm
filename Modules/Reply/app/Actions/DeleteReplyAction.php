<?php

namespace Modules\Reply\Actions;

use Illuminate\Support\Facades\Storage;

class DeleteReplyAction
{
    public function handle($reply)
    {
        if ($reply->image) {
            Storage::disk('public')->delete($reply->image);
        }

        $reply->delete();
    }
}