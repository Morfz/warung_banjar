<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ReservationStatus;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;

class ReservationStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'date' => ['required', 'date', new DateBetween, new TimeBetween],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
            'table_id' => ['required', Rule::exists('tables', 'id')],
            'status' => ['nullable', Rule::enum(ReservationStatus::class)],
        ];
    }
}

