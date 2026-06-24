<?php

namespace App\Enums;

enum TableStatus: string
{
    case Pending = 'pending';
    case Available = 'available';
    case Unavailable = 'unavailable';

    /**
     * Warna badge Tailwind sesuai status untuk tampilan admin.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Available  => 'bg-emerald-100 text-emerald-700',
            self::Pending    => 'bg-amber-100 text-amber-700',
            self::Unavailable => 'bg-rose-100 text-rose-700',
        };
    }

    /**
     * Label ramah-baca dalam Bahasa Indonesia.
     */
    public function label(): string
    {
        return match ($this) {
            self::Available  => 'Tersedia',
            self::Pending    => 'Dipesan',
            self::Unavailable => 'Tidak Tersedia',
        };
    }
}
