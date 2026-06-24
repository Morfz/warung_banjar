<?php

namespace App\Http\Requests;

use App\Enums\TableStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableStoreRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:80'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'status' => ['required', Rule::enum(TableStatus::class)],
            'layout_x' => ['nullable', 'integer', 'min:0', 'max:100'],
            'layout_y' => ['nullable', 'integer', 'min:0', 'max:100'],
            'layout_shape' => ['nullable', 'string', Rule::in(['vertical', 'horizontal'])],
        ];
    }
}
