<?php

namespace Modules\Reply\Actions;

use Modules\Reply\Models\Reply;

class ListRepliesAction
{
    public function handle()
    {
        return Reply::with(['user', 'ticket'])->latest()->get();
    }
}
