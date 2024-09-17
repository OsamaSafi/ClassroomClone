<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // لما اكون بديش يدخل اسم معين من خلال كول باك ميثود
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($a, $v, $f) {
                    if ($v == 'admin') {
                        return $f('This name is forbiden');
                    }
                }
            ],
            'section' => [
                'nullable',
                'string',
                'max:255'
            ],
            'subject' => [
                'nullable',
                'string',
                'max:255'
            ],
            'room' => [
                'nullable',
                'string',
                'max:255'
            ],
            'cover_image' => [
                'nullable',
                'image',
                'dimensions:min_width=300,min_height=200'
            ]
        ];
    }

    // public function messages():array
    // {
    //     return [];
    // }
}
