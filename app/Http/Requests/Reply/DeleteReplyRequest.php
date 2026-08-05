<?php

namespace App\Http\Requests\Reply;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReplyRequest extends FormRequest
{
    public function authorize()
    {
          return $this->user()->is_admin;
    }
    protected function failedAuthorization()
    {
        abort(403, 'تەنها ئادمین دەتوانێت وەڵام رەش بکاتەوە.');
    }
}