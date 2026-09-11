<?php

namespace App\Http\Requests\Kesra;

use Illuminate\Foundation\Http\FormRequest;

class DecideChildRecordRequest extends FormRequest
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
            'decision' => ['required', 'in:approve,reject'],
            'notes' => ['required', 'string', 'max:2000'],
        ];
    }
}
