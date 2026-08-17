<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTicketRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->is_admin;
    }

    protected function failedAuthorization()
    {   
        abort(403, __('messages.ticket_failed_authorization'));
    }
}
