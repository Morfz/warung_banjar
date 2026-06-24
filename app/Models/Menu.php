<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu');
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
            'Soto Banjar' => 'img/menu-1.png',
            'Nasi Goreng Banjar' => 'img/menu-2.png',
            'Ayam Bakar Rempah' => 'img/menu-3.png',
            'Pisang Ijo' => 'img/menu-4.png',
            'Es Tebu' => 'img/menu-5.png',
            'Temulawak Hangat' => 'img/menu-6.png',
            default => 'img/menu-1.png',
        };
    }
}
