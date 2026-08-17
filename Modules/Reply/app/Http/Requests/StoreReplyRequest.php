<?php

namespace Modules\Reply\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize()
    {
        $user = $this->user();
        $ticket = $this->route('ticket');

        return $ticket->status !== 'closed'&&($user->is_admin ||
           ((int) $ticket->user_id === (int) $user->id
            &&
             $ticket->replies()->whereHas('user',fn ($query) => $query->where('is_admin', true))->exists()
        ));
    }

    public function rules()
    {
        return [
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, __('messages.reply_failed_authorization'));
    }
}
