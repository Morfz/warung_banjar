<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
class WelcomeController extends Controller
{
    public function index()
    {
        $specials = Category::with('menus')->where('name', 'Menu Spesial')->first();
        $randomMenu = $specials?->menus()->inRandomOrder()->first();

        $categories = Category::with('menus')
            ->whereNotIn('name', ['Menu Spesial'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('welcome', compact('specials', 'randomMenu', 'categories'));
    }
}
