<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $products = collect([
            [
                'name' => 'Beras Ramos Premium 5kg',
                'category' => 'Beras',
                'unit' => 'sak',
                'price' => 79000,
                'stock' => 40,
            ],
            [
                'name' => 'Beras Medium 5kg',
                'category' => 'Beras',
                'unit' => 'sak',
                'price' => 68500,
                'stock' => 45,
            ],
            [
                'name' => 'Minyak Goreng 2L',
                'category' => 'Minyak',
                'unit' => 'botol',
                'price' => 34500,
                'stock' => 55,
            ],
            [
                'name' => 'Gula Pasir 1kg',
                'category' => 'Gula',
                'unit' => 'bungkus',
                'price' => 17500,
                'stock' => 70,
            ],
            [
                'name' => 'Tepung Terigu 1kg',
                'category' => 'Tepung',
                'unit' => 'bungkus',
                'price' => 12800,
                'stock' => 60,
            ],
            [
                'name' => 'Telur Ayam 1kg',
                'category' => 'Protein',
                'unit' => 'kg',
                'price' => 30500,
                'stock' => 42,
            ],
            [
                'name' => 'Mie Instan Goreng (5 pcs)',
                'category' => 'Makanan Instan',
                'unit' => 'pak',
                'price' => 16500,
                'stock' => 90,
            ],
            [
                'name' => 'Susu UHT Cokelat 1L',
                'category' => 'Minuman',
                'unit' => 'kotak',
                'price' => 19800,
                'stock' => 35,
            ],
        ]);

        $products->each(function (array $product): void {
            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        });
    }
}
