<?php

namespace App\Http\Requests\Reply;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->is_admin;
    }

    public function rules()
    {
        return [
            'message' => 'required|string',
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'تەنها ئادمین دەتوانێت وەڵام بداتەوە.');
    }
}