<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize()
    {
        return (bool) $this->user()->is_admin;
    }

    public function rules()
    {
        return [
            'status' => 'sometimes|nullable|in:open,in_progress,resolved,closed',
            'priority' => 'sometimes|nullable|in:low,medium,high',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, __('messages.ticket_failed_authorization'));
    }
}
