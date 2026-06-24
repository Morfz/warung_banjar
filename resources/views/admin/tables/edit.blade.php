<x-admin-layout>
    <x-slot name="header">Edit Meja</x-slot>

    <x-admin-form-card title="Edit Meja" description="Perbarui detail meja." :back="route('admin.tables.index')">
        <form method="POST" action="{{ route('admin.tables.update', $table->id) }}" class="max-w-2xl space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-800">Nama Meja</label>
                <input type="text" id="name" name="name" value="{{ old('name', $table->name) }}" autofocus
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('name') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                @error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="capacity" class="block text-sm font-semibold text-slate-800">Kapasitas (tamu)</label>
                <input type="number" min="1" max="20" id="capacity" name="capacity" value="{{ old('capacity', $table->capacity) }}"
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('capacity') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                @error('capacity')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-slate-800">Status</label>
                <select id="status" name="status"
                    class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('status') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror">
                    @foreach(\App\Enums\TableStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $table->status->value) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-5">
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    Perbarui Meja
                </button>
            </div>
        </form>
    </x-admin-form-card>
</x-admin-layout>
