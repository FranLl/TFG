<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;   // EN EL TUTORIAL ESTA A TRUE
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            # https://laravel.com/docs/11.x/validation#available-validation-rules
            'blockId' => ['required', 'string', 'size:66', 'start_with:0x']
        ];
    }
}
