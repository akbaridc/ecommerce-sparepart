<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Site;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Akbar Imawan Dwi Cahya',
            'email' => 'akbar@gmail.com',
        ]);

        Site::factory()->create();

        // Category::factory(10)->create();
        // Product::factory(30)->create();
    }
}
