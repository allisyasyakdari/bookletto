<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@bookletto.test'],
            [
                'name' => 'Bookletto Admin',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'reader@bookletto.test'],
            [
                'name' => 'Nadia Reader',
                'phone' => '082233445566',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $categories = collect([
            ['name' => 'Fiksi Sastra', 'description' => 'Cerita dengan nuansa sinematik dan humanis.', 'icon' => 'book-open', 'sort_order' => 1],
            ['name' => 'Bisnis', 'description' => 'Insight praktis untuk bertumbuh.', 'icon' => 'briefcase', 'sort_order' => 2],
            ['name' => 'Psikologi', 'description' => 'Membaca perilaku, emosi, dan motivasi.', 'icon' => 'sparkles', 'sort_order' => 3],
            ['name' => 'Sains', 'description' => 'Rasa ingin tahu yang dikemas elegan.', 'icon' => 'globe', 'sort_order' => 4],
            ['name' => 'Sejarah', 'description' => 'Narasi masa lalu yang relevan hari ini.', 'icon' => 'landmark', 'sort_order' => 5],
            ['name' => 'Motivasi', 'description' => 'Dorongan ringan untuk bergerak maju.', 'icon' => 'feather', 'sort_order' => 6],
            ['name' => 'Non-Fiksi', 'description' => 'Tulisan informatif dan berisi.', 'icon' => 'bookmark', 'sort_order' => 7],
            ['name' => 'Anak-anak', 'description' => 'Hangat, cerah, dan penuh imajinasi.', 'icon' => 'star', 'sort_order' => 8],
        ])->map(function (array $category) {
            return Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                array_merge($category, ['slug' => Str::slug($category['name'])])
            );
        });

        $this->call(PromoSeeder::class);
    }
}
