<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BatchUpdateBlogRequest extends FormRequest
{
    protected $errorBag = 'batchUpdate';

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blogs'           => 'required|array',
            'blogs.*.id'      => 'required|integer|exists:posts,id',
            'blogs.*.title'   => 'required|string|max:255',
            'blogs.*.content' => 'required|string',
        ];
    }
}
