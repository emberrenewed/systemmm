<?php

namespace Modules\Reply\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Reply\Actions\CreateReplyAction;
use Modules\Reply\Actions\DeleteReplyAction;
use Modules\Reply\Http\Requests\DeleteReplyRequest;
use Modules\Reply\Http\Requests\StoreReplyRequest;
use Modules\Reply\Http\Resources\ReplyResource;
use Modules\Reply\Models\Reply;
use Modules\Ticket\Models\Ticket;

class ReplyController extends Controller
{
    public function store(StoreReplyRequest $request, Ticket $ticket, CreateReplyAction $action)
    {
        $result = $action->handle($request->user(), $ticket, $request->validated());

        return ReplyResource::make($result['reply'])->additional(['message' => (__('messages.reply_created')),'',
            'ticket_status' => $result['ticket_status'], ])->response()->setStatusCode(201);
    }

    public function destroy(DeleteReplyRequest $request, Reply $reply, DeleteReplyAction $action)
    {
        $action->handle($reply);

        return response()->json(['message' => (__('messages.reply_deleted'))]);
    }
}
