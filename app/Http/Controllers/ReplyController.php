<?php

namespace App\Http\Controllers;

use App\Actions\Reply\CreateReplyAction;
use App\Actions\Reply\DeleteReplyAction;
use App\Http\Requests\Reply\DeleteReplyRequest;
use App\Http\Requests\Reply\StoreReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Ticket;

class ReplyController extends Controller
{
    //store
    public function store(StoreReplyRequest $request, Ticket $ticket, CreateReplyAction $action)
    {
        $result = $action->handle($request->user(), $ticket, $request->validated());

        return ReplyResource::make($result['reply'])->additional(['message' => 'Reply added successfully.',
              'ticket_status' => $result['ticket_status'],])->response()->setStatusCode(201);
    }

    //destroy
    public function destroy(DeleteReplyRequest $request, Reply $reply, DeleteReplyAction $action)
    {
    
        $action->handle($reply);
        return response()->json(['message' => 'Reply deleted successfully.',]);
    }
}
