<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => ['required', 'exists:categories,id'],
                'author' => ['string', 'max:50'],
                'isFeatured' => ['boolean'],
                'tags' => ['array'],
                'tags' => ['required', 'exists:tags,id'],
            ];
        } else {
            return [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => ['required', 'exists:categories,id'],
                // 'author' => ['string', 'max:50'],
                // 'tags' => ['array'],
                // 'tags' => ['required', 'exists:tags,id'],
            ];
        }
    }

    public function errorMessages(): array
    {
        return [
            'title.required' => 'A title is required',
            'description.required' => 'A description is required',
            'image.required' => 'An image is required',
            'category_id.required' => 'A category is required',
            'author.required' => 'An author is required',
            'isFeatured.required' => 'A isFeatured is required',
            'tags.required' => 'A tag is required',
        ];
    }
}
