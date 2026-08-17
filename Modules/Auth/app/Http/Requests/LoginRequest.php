<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function authenticate()
    {
        if (! Auth::attempt($this->validated())) {
            throw ValidationException::withMessages([
                'email' => __('messages.login_failed'),
            ]);
        }
    }
}
