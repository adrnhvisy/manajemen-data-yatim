<?php

namespace App\Http\Requests\Kelurahan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChildRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
    * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['sometimes', 'string', 'max:255'],
            'birth_date' => ['sometimes', 'date', 'before_or_equal:today'],
            'address' => ['sometimes', 'string'],
        ];
    }
}
