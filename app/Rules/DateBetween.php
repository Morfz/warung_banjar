<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateBetween implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $pickUpDate = Carbon::parse($value);
        } catch (\Exception $exception) {
            return false;
        }

        $lastDate = Carbon::now()->addWeek();

        return $pickUpDate->greaterThanOrEqualTo(Carbon::now())
            && $pickUpDate->lessThanOrEqualTo($lastDate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Pilih tanggal reservasi mulai sekarang sampai tujuh hari ke depan.';
    }
}
