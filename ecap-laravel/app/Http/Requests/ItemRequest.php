<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Admin middleware already enforces authorization for admin routes
        return true;
    }

    public function rules(): array
    {
        $no = $this->input('no');
        $isUpdate = (bool) $no;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'short_dis' => ['required', 'string'],
            'long_dis' => ['required', 'string'],
            'type' => ['required', 'integer', 'exists:itemtypes,no'],
            'content' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'trademark' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];

        if ($isUpdate) {
            $rules['images'] = ['sometimes', 'array', 'max:8'];
            $rules['images.*'] = ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
        } else {
            $rules['images'] = ['required', 'array', 'max:8'];
            $rules['images.*'] = ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
        }

        return $rules;
    }
}
