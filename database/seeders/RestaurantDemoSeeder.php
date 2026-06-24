<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class RestaurantDemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            [
                'name' => 'Makanan Pembuka',
                'description' => 'Sajian ringan untuk membuka selera sebelum hidangan utama.',
                'image' => 'categories/O8HGQiryI49HnkFcLmbMlRMdeiFu1gW00JPo0qGK.jpg',
            ],
            [
                'name' => 'Makanan Utama',
                'description' => 'Hidangan khas Banjar yang hangat, gurih, dan mengenyangkan.',
                'image' => 'categories/TAdoj4hTgRc423Cr6bSwLgtXk8dfuLPejiQ9Sdcv.jpg',
            ],
            [
                'name' => 'Makanan Penutup',
                'description' => 'Penutup manis yang pas untuk mengakhiri santap bersama.',
                'image' => 'categories/SgvBh3Owd0UBJdc0KnZ3j06Ufk2wVF9VquNhOA5i.jpg',
            ],
            [
                'name' => 'Minuman Dingin',
                'description' => 'Minuman segar untuk menemani hidangan favorit Anda.',
                'image' => 'categories/LKQKQGJAKXJPr16HEmpfvhBrxbh5LgAdxJo2H3Dy.jpg',
            ],
            [
                'name' => 'Minuman Hangat',
                'description' => 'Racikan hangat dengan rasa tradisional yang menenangkan.',
                'image' => 'categories/hDoKHMrDPBDcsN5oEmDvpWR5ApsSeACSLfAj1opQ.jpg',
            ],
            [
                'name' => 'Menu Spesial',
                'description' => 'Rekomendasi pilihan dari dapur Warung Banjar.',
                'image' => 'categories/fwpDe1voTA2KKjiTxqVXsin2GUSOKcUD1E61v8SN.jpg',
            ],
        ])->mapWithKeys(fn (array $category) => [
            $category['name'] => Category::updateOrCreate(
                ['name' => $category['name']],
                $category,
            ),
        ]);

        foreach ($this->menus() as $data) {
            $categoryNames = $data['categories'];
            unset($data['categories']);

            $menu = Menu::updateOrCreate(['name' => $data['name']], $data);
            $menu->categories()->sync(
                collect($categoryNames)
                    ->map(fn (string $name) => $categories[$name]->id)
                    ->all(),
            );
        }

        // Seed dummy reservations for today
        $table1 = \App\Models\Table::where('name', 'Meja 1')->first();
        $table2 = \App\Models\Table::where('name', 'Meja 2')->first();
        $table12 = \App\Models\Table::where('name', 'Meja 12')->first();
        $table17 = \App\Models\Table::where('name', 'Meja 17')->first();

        if ($table1 && $table2 && $table12 && $table17) {
            $today = \Carbon\Carbon::today()->toDateString();
            
            \App\Models\Reservation::updateOrCreate(
                ['email' => 'budi@example.com'],
                [
                    'name' => 'Budi Santoso',
                    'phone' => '08123456789',
                    'date' => "{$today} 12:00:00",
                    'guests' => 2,
                    'status' => \App\Enums\ReservationStatus::Pending->value,
                    'table_id' => $table1->id,
                ]
            );

            \App\Models\Reservation::updateOrCreate(
                ['email' => 'siti@example.com'],
                [
                    'name' => 'Siti Rahma',
                    'phone' => '08987654321',
                    'date' => "{$today} 13:30:00",
                    'guests' => 4,
                    'status' => \App\Enums\ReservationStatus::Confirmed->value,
                    'table_id' => $table2->id,
                ]
            );

            \App\Models\Reservation::updateOrCreate(
                ['email' => 'joko@example.com'],
                [
                    'name' => 'Joko Widodo',
                    'phone' => '08111111111',
                    'date' => "{$today} 19:00:00",
                    'guests' => 6,
                    'status' => \App\Enums\ReservationStatus::Completed->value,
                    'table_id' => $table12->id,
                ]
            );

            \App\Models\Reservation::updateOrCreate(
                ['email' => 'ani@example.com'],
                [
                    'name' => 'Ani Yudhoyono',
                    'phone' => '08222222222',
                    'date' => "{$today} 20:30:00",
                    'guests' => 8,
                    'status' => \App\Enums\ReservationStatus::Cancelled->value,
                    'table_id' => $table17->id,
                ]
            );
        }
    }

    private function menus(): array
    {
        return [
            [
                'name' => 'Soto Banjar',
                'description' => 'Kuah rempah bening dengan suwiran ayam, telur, perkedel, dan ketupat.',
                'price' => 25000,
                'image' => 'menus/CzrbG2rVFaLQbS0Fz5y3yHla8sgbkqv1pCKkiccc.jpg',
                'categories' => ['Makanan Utama', 'Menu Spesial'],
            ],
            [
                'name' => 'Nasi Goreng Banjar',
                'description' => 'Nasi goreng wangi dengan bumbu khas, telur, acar, dan kerupuk.',
                'price' => 22000,
                'image' => 'menus/wvy6J0r9w9YICGmUcJEQzISNvlB4ugNOvjhYakjQ.webp',
                'categories' => ['Makanan Utama', 'Menu Spesial'],
            ],
            [
                'name' => 'Ayam Bakar Rempah',
                'description' => 'Ayam bakar bumbu kuning dengan sambal dan lalapan segar.',
                'price' => 28000,
                'image' => 'menus/zklU0LB783OoeWasp7YgbUSQ0Yh3YW8JFrc0USsu.jpg',
                'categories' => ['Makanan Utama'],
            ],
            [
                'name' => 'Pisang Ijo',
                'description' => 'Pisang lembut berbalut adonan hijau, sirup, dan kuah santan.',
                'price' => 12000,
                'image' => 'menus/mOfiK3FK2nqd4L1POW2Mi3AEQTtKOwqBJdTvAxQq.jpg',
                'categories' => ['Makanan Penutup', 'Menu Spesial'],
            ],
            [
                'name' => 'Es Tebu',
                'description' => 'Sari tebu dingin yang manis alami dan menyegarkan.',
                'price' => 10000,
                'image' => 'menus/FIGeIS23QzjOwW0WV3vchhebFN2ehPZB0ALdqkmc.jpg',
                'categories' => ['Minuman Dingin', 'Menu Spesial'],
            ],
            [
                'name' => 'Temulawak Hangat',
                'description' => 'Minuman herbal hangat dengan rasa manis rempah yang ringan.',
                'price' => 10000,
                'image' => 'menus/ywvRzFy4eaFtWsPzGddY6L5U9ILtKWwrb76PFeTt.jpg',
                'categories' => ['Minuman Hangat'],
            ],
        ];
    }

}
