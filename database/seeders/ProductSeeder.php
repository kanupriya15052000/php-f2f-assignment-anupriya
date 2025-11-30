<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Product::create([
        'name' => 'Mobile',
        'slug' => 'mobile',
        'sku' => 'SKU-MOBILE-001',
        'price' => 10000,
    ]);

    Product::create([
        'name' => 'Laptop',
        'slug' => 'laptop',
        'sku' => 'SKU-LAPTOP-001',
        'price'=> 50000,
    ]);

    Product::create([
        'name' => 'Headphones',
        'slug' => 'headphones',
        'sku' => 'SKU-HEADPHONES-001',
        'price' => 2000,
    ]);
    }
}
