<?php

namespace Database\Seeders;

use App\Enums\TableStatus;
use App\Models\Table;
use Illuminate\Database\Seeder;

class DiningRoomTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->tables() as $table) {
            Table::updateOrCreate(
                ['name' => $table['name']],
                $table,
            );
        }
    }

    private function tables(): array
    {
        return [
            ['name' => 'Meja 1', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 9, 'layout_y' => 14, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 2', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 9, 'layout_y' => 31, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 3', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 9, 'layout_y' => 48, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 4', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 22, 'layout_y' => 14, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 5', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 22, 'layout_y' => 31, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 6', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 22, 'layout_y' => 48, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 7', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 14, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 8', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 31, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 9', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 48, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 10', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 75, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 11', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 91, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 12', 'capacity' => 6, 'status' => TableStatus::Available->value, 'layout_x' => 54, 'layout_y' => 14, 'layout_shape' => 'horizontal'],
            ['name' => 'Meja 13', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 54, 'layout_y' => 31, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 14', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 54, 'layout_y' => 48, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 15', 'capacity' => 4, 'status' => TableStatus::Available->value, 'layout_x' => 54, 'layout_y' => 75, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 16', 'capacity' => 6, 'status' => TableStatus::Available->value, 'layout_x' => 54, 'layout_y' => 91, 'layout_shape' => 'horizontal'],
            ['name' => 'Meja 17', 'capacity' => 8, 'status' => TableStatus::Available->value, 'layout_x' => 73, 'layout_y' => 17, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 18', 'capacity' => 6, 'status' => TableStatus::Available->value, 'layout_x' => 73, 'layout_y' => 43, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 19', 'capacity' => 8, 'status' => TableStatus::Available->value, 'layout_x' => 73, 'layout_y' => 62, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 20', 'capacity' => 8, 'status' => TableStatus::Available->value, 'layout_x' => 73, 'layout_y' => 88, 'layout_shape' => 'vertical'],
            ['name' => 'Meja 28', 'capacity' => 2, 'status' => TableStatus::Available->value, 'layout_x' => 36, 'layout_y' => 60, 'layout_shape' => 'vertical'],
        ];
    }
}
