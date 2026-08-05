<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class ShowTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $ticket = $this->route('ticket');
        return $user->is_admin || $ticket->user_id === $user->id;
    }
    protected function failedAuthorization()
    {
        abort(403, 'تەنها دەتوانیت تیکێتی خۆت ببینیت.');
    }
}
