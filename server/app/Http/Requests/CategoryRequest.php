<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        if (request()->isMethod('put')) {
            return [
                'name' => [
                    'required',
                    Rule::unique('categories', 'name')->ignore(request()->input('id')),
                    'max:100',
                ],
            ];
        }
        return [
            'name' => 'required|unique:categories,name|max:100',
        ];
    }
}
