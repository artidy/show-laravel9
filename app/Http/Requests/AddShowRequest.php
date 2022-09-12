<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'imdbId' => ['required', 'regex:/^tt\d+$/', 'unique:shows,imdb_id']
        ];
    }

    public function messages(): array
    {
        return [
            'imdb.regex' => 'imdb id должен быть передан в формате ttNNNN',
            'imdb.unique' => 'Такой сериал уже есть'
        ];
    }
}
