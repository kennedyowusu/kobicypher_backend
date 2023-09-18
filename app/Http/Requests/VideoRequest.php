<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        if(request()->isMethod('post')){
            return [
                'title' => 'required|string|max:255',
                'link' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => 'required|exists:categories,id',
            ];
        } else {
            return [
                'title' => 'string|max:255',
                'link' => 'string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => 'required|exists:categories,id',
            ];
        }
    }

    public function errorMessages(): array
    {
        return [
            'title.required' => 'A title is required',
            'link.required' => 'A link is required',
            'image.required' => 'An image is required',
            'category_id.required' => 'A category is required',
        ];
    }
}
