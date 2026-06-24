<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    /**
     * Warna badge Tailwind sesuai status untuk tampilan admin.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending   => 'bg-amber-100 text-amber-700',
            self::Confirmed => 'bg-emerald-100 text-emerald-700',
            self::Cancelled => 'bg-rose-100 text-rose-700',
            self::Completed => 'bg-sky-100 text-sky-700',
        };
    }

    public function publicBadgeClasses(): string
    {
        return match ($this) {
            self::Pending   => 'reservation-status--pending',
            self::Confirmed => 'reservation-status--confirmed',
            self::Cancelled => 'reservation-status--cancelled',
            self::Completed => 'reservation-status--completed',
        };
    }

    /**
     * Label ramah-baca dalam Bahasa Indonesia.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Menunggu',
            self::Confirmed => 'Dikonfirmasi',
            self::Cancelled => 'Dibatalkan',
            self::Completed => 'Selesai',
        };
    }
}
