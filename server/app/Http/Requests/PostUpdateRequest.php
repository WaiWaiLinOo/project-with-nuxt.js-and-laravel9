<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class PostUpdateRequest extends FormRequest
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
            'image' => ['nullable', File::image()->max(2048)],
            'title' => ['required', Rule::unique('posts', 'title')->ignore((int) $this->segment(4)), 'max:255'],
            'body' => ['required'],
            'categories' => ['required', 'array'],
        ];
    }
}
