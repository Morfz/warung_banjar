<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::latest()->paginate(10);

        return view('admin.tables.index', compact('tables'));
    }

    public function layout()
    {
        $tables = Table::query()
            ->get()
            ->sortBy(fn (Table $table) => (int) preg_replace('/\D+/', '', $table->name))
            ->values();

        return view('admin.tables.layout', compact('tables'));
    }

    public function updateLayout(Request $request)
    {
        $validated = $request->validate([
            'tables' => ['required', 'array'],
            'tables.*.id' => ['required', Rule::exists('tables', 'id')],
            'tables.*.layout_x' => ['required', 'integer', 'min:0', 'max:100'],
            'tables.*.layout_y' => ['required', 'integer', 'min:0', 'max:100'],
            'tables.*.layout_shape' => ['required', 'string', Rule::in(['vertical', 'horizontal'])],
        ]);

        foreach ($validated['tables'] as $table) {
            $model = Table::findOrFail($table['id']);
            $shape = $this->normalizeLayoutShape((int) $model->capacity, $table['layout_shape']);

            Table::whereKey($table['id'])->update([
                'layout_x' => $table['layout_x'],
                'layout_y' => $table['layout_y'],
                'layout_shape' => $shape,
            ]);
        }

        return back()->with('success', 'Denah meja berhasil disimpan.');
    }

    private function normalizeLayoutShape(int $capacity, string $shape): string
    {
        return $shape === 'horizontal' ? 'horizontal' : 'vertical';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableStoreRequest $request)
    {
        Table::create($request->validated());

        return to_route('admin.tables.index')->with('success', 'Meja berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        return redirect()->route('admin.tables.edit', $table);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableStoreRequest $request, Table $table)
    {
        $table->update($request->validated());

        return to_route('admin.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->reservations()->delete();
        $table->delete();

        return to_route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
