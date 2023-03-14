<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'suggested_treatment' => 'required|string',
            'tests' => 'nullable|json',
        ];
    }
}
