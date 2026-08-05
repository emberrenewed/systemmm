<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize()
    {
        $user = $this->user();
        $ticket = $this->route('ticket');

        if ($user->is_admin || $ticket->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function rules()
    {
        $rules = [
            'status' => 'sometimes|required|in:open,in_progress,resolved,closed',
        ];

        if ($this->user()->is_admin) {
            $rules['priority'] = 'sometimes|in:low,medium,high';
        }

        return $rules;
    }

    protected function failedAuthorization()
    {
        abort(403, 'تەنها دەتوانیت تیکێتی خۆت نوێ بکەیتەوە.');
    }
}
