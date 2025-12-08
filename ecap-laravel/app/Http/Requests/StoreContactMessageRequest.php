<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:191'],
            'email' => ['required','email','max:191'],
            'subject' => ['nullable','string','max:191'],
            'message' => ['required','string','max:5000'],
        ];
    }
}
