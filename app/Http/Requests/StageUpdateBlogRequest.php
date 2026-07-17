<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StageUpdateBlogRequest extends FormRequest
{
    protected $errorBag = 'stageUpdate';

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
        $id = $this->route('id');

        return [
            "edit.title.$id" => 'required|string|max:255',
            "edit.content.$id" => 'required|string',
        ];
    }

    public function attributes(): array
    {
        $id = $this->route('id');

        return [
            "edit.title.$id" => 'title',
            "edit.content.$id" => 'content',
        ];
    }
}
