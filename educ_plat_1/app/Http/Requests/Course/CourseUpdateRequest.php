<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название курса обязательно',
            'description.required' => 'Описание обязательно',
            'level.in' => 'Выберите допустимый уровень сложности',
        ];
    }
}
