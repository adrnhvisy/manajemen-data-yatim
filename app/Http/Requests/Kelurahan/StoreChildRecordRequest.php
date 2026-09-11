<?php

namespace App\Http\Requests\Kelurahan;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildRecordRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'child_status' => ['required', 'in:yatim,piatu,yatim piatu'],
            'address' => ['required', 'string'],
            'office_id' => ['required', 'uuid', 'exists:offices,id'],
        ];
    }
}
