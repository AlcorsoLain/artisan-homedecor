<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::table('users')->insert([
            'name' => 'SIllon',
            'price' => 2000,
            'category' => 1,
            'string' => 'Es un sillon',
        ]);
    }
}
