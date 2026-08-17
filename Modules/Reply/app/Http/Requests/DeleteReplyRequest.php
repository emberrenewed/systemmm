<?php

namespace Modules\Reply\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReplyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->is_admin;
    }

    protected function failedAuthorization()
    {
        abort(403, __('messages.reply_delete_admin_only'));
    }
}
