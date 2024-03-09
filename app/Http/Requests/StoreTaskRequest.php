<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "title" => ['required', 'max:20'],
            "content" => ['max:30'],
            "begin" => ['required', 'date'],
            "end" => ["nullable", 'date', 'after:begin'],
            "status" => ['required', 'integer', 'between:0,2'],
            "published" => ['required', 'integer', 'between:0,1'],
            "remarks" => ['max:50'],
        ];
    }
}