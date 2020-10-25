<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatrixRequestForm extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'matrix_1' => ['required'],
            'matrix_2' => ['required'],
            'matrix_1.*.*' => ['required', 'numeric'],
            'matrix_2.*.*' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'matrix_1.required' => 'Please fill in Matrix 1',
            'matrix_2.required' => 'Please fill in Matrix 2',
        ];
    }
}
