<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class TimeBetween implements Rule
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

        if ($pickUpDate->minute % 30 !== 0) {
            return false;
        }

        $pickUpTime = Carbon::createFromTime($pickUpDate->hour, $pickUpDate->minute, $pickUpDate->second);

        $openTime = Carbon::createFromTimeString('08:00:00');
        $closeTime = Carbon::createFromTimeString('22:00:00');

        return $pickUpTime->between($openTime, $closeTime);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Pilih jam reservasi dengan interval 30 menit (contoh: 10:30, 12:00) antara 08.00 dan 22.00.';
    }
}
