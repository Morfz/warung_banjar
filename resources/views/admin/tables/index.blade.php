<x-admin-layout>
    <x-slot name="header">Meja</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-950">Daftar Meja</h2>
                <p class="text-sm text-slate-500">{{ $tables->total() }} meja terdaftar.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.tables.layout') }}" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-amber-300 hover:bg-amber-50">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h16.5v16.5H3.75zM8 8h2.5v2.5H8zM14 8h2.5v2.5H14zM8 14h2.5v2.5H8zM14 14h2.5v2.5H14z"/></svg>
                    Atur Denah
                </a>
                <a href="{{ route('admin.tables.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Meja
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Kapasitas</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($tables as $table)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-semibold text-slate-950">{{ $table->name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $table->capacity }} tamu</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $table->status->badgeClasses() }}">
                                    {{ $table->status->label() }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.tables.edit', $table->id) }}" class="rounded-md bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-800 transition hover:bg-amber-200">Edit</a>
                                    <form method="POST" action="{{ route('admin.tables.destroy', $table->id) }}" onsubmit="return confirm('Hapus meja ini? Seluruh reservasi terkait juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-500">Belum ada meja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin-pagination :paginator="$tables" />
    </div>
</x-admin-layout>
