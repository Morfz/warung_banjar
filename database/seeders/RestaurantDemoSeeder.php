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
