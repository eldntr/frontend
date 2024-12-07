<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Cek jika tidak ada user dengan role 'seller', buat beberapa user seller
        $sellers = User::where('role', 'seller')->get();
        if ($sellers->isEmpty()) {
            for ($j = 0; $j < 5; $j++) { // misal tambahkan 5 user seller
                User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('password'), // Ganti dengan password yang sesuai
                    'role' => 'seller',
                ]);
            }

            // Dapatkan kembali data seller setelah dibuat
            $sellers = User::where('role', 'seller')->get();
        }

        // Buat beberapa kategori
        $categories = Category::factory()->count(10)->create();

        // Loop untuk setiap seller dan buat produk
        foreach ($sellers as $seller) {
            for ($i = 0; $i < 25; $i++) {
                // Download gambar dari faker
                $imageUrl = $faker->imageUrl(640, 480, 'products', true);
                $imageContents = file_get_contents($imageUrl);
                $imageName = 'products/' . $faker->uuid . '.jpg';
                Storage::disk('public')->put($imageName, $imageContents);

                // Pilih kategori secara acak
                $category = $categories->random();

                // Buat produk
                Product::create([
                    'name' => $faker->word,
                    'description' => $faker->sentence,
                    'image' => $imageName,
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'stock' => $faker->numberBetween(1, 100),
                    'seller_id' => $seller->id,
                    'category_id' => $category->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
