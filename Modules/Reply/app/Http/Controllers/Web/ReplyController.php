<?php

namespace Modules\Reply\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Modules\Reply\Actions\CreateReplyAction;
use Modules\Reply\Actions\ListRepliesAction;
use Modules\Reply\Http\Requests\StoreReplyRequest;
use Modules\Ticket\Models\Ticket;

class ReplyController extends Controller
{
    public function index(ListRepliesAction $action)
    {
        $replies = $action->handle();

        return view('reply::index', ['replies' => $replies]);
    }

    public function store(StoreReplyRequest $request, Ticket $ticket, CreateReplyAction $action)
    {
        $action->handle($request->user(), $ticket, $request->validated());

        return back()->with('success', 'Reply sent successfully.');
    }
}
