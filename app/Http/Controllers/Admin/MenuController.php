<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('categories')->latest()->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')->store('public/menus');

        $menu = Menu::create($validated);
        $menu->categories()->sync($validated['categories'] ?? []);

        return to_route('admin.menus.index')->with('success', 'Menu berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return redirect()->route('admin.menus.edit', $menu);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($menu->image);
            $validated['image'] = $request->file('image')->store('public/menus');
        }

        $menu->update($validated);
        $menu->categories()->sync($validated['categories'] ?? []);

        return to_route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Storage::delete($menu->image);
        $menu->categories()->detach();
        $menu->delete();

        return to_route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
