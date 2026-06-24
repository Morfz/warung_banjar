<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'guests',
        'table_id',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => ReservationStatus::class,
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
