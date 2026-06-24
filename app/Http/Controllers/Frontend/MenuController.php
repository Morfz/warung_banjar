<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categoryOrder = [
            'Makanan Pembuka',
            'Makanan Utama',
            'Makanan Penutup',
            'Minuman Hangat',
            'Minuman Dingin',
        ];

        $categories = Category::with('menus')
            ->whereIn('name', $categoryOrder)
            ->get()
            ->sortBy(fn ($category) => array_search($category->name, $categoryOrder))
            ->values();

        return view('menus.index', compact('categories'));
    }
}
