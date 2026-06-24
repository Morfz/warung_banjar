<x-admin-layout>
    <x-slot name="header">Tambah Menu</x-slot>

    <x-admin-form-card title="Menu Baru" description="Lengkapi detail menu di bawah ini." :back="route('admin.menus.index')">
        <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-800">Nama Menu</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" autofocus
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('name') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                @error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-slate-800">Gambar</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="mt-1.5 block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800 @error('image') border-rose-400 @enderror" />
                @error('image')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-slate-800">Harga (Rp)</label>
                <input type="number" min="0" step="500" id="price" name="price" value="{{ old('price') }}"
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('price') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                @error('price')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-800">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('description') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="categories" class="block text-sm font-semibold text-slate-800">Kategori <span class="font-normal text-slate-400">(boleh pilih lebih dari satu)</span></label>
                <select id="categories" name="categories[]" multiple
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('categories')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-5">
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Simpan Menu
                </button>
            </div>
        </form>
    </x-admin-form-card>
</x-admin-layout>
