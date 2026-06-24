<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'image',
        'description',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'category_menu');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'media:')) {
            return route('media.show', (int) str($this->image)->after('media:')->toString());
        }

        if ($this->image && preg_match('/^https?:\/\//', $this->image)) {
            return $this->image;
        }

        $path = $this->normalizedImagePath();

        if ($path && file_exists(storage_path('app/public/'.$path))) {
            return Storage::url($path);
        }

        return asset($this->fallbackImagePath());
    }

    private function normalizedImagePath(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str($this->image)->replaceStart('public/', '')->toString();
    }

    private function fallbackImagePath(): string
    {
        return match ($this->name) {
            'Makanan Pembuka' => 'img/service-1.jpg',
            'Makanan Utama' => 'img/service-2.jpg',
            'Makanan Penutup' => 'img/service-3.jpg',
            'Minuman Dingin' => 'img/hero-slider-2.jpg',
            'Minuman Hangat' => 'img/hero-slider-3.jpg',
            default => 'img/hero-slider-1.jpg',
        };
    }
}
