<x-admin-layout>
    <x-slot name="header">Menu</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-950">Daftar Menu</h2>
                <p class="text-sm text-slate-500">{{ $menus->total() }} menu tersedia.</p>
            </div>
            <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Menu
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Menu</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Harga</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($menus as $menu)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="h-16 w-16 rounded-md object-cover">
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $menu->name }}</p>
                                        <p class="max-w-xl text-sm text-slate-500">{{ Str::limit($menu->description, 100) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse ($menu->categories as $category)
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $category->name }}</span>
                                    @empty
                                        <span class="text-slate-400">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-900">Rp{{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="rounded-md bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-800 transition hover:bg-amber-200">Edit</a>
                                    <form method="POST" action="{{ route('admin.menus.destroy', $menu->id) }}" onsubmit="return confirm('Hapus menu ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-500">Belum ada menu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin-pagination :paginator="$menus" />
    </div>
</x-admin-layout>
