<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $products = [
            // Smartphones
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'slug' => 'samsung-galaxy-s23-ultra',
                'description' => 'Smartphone Samsung haut de gamme avec appareil photo avancé et écran Dynamic AMOLED.',
                'price' => 650000,
                'compare_price' => 720000,
                'stock' => 15,
                'sku' => 'SM-S23U-001',
                'brand' => 'Samsung',
                'features' => ['Écran 6.8"', '256GB Stockage', 'Appareil photo 200MP', 'Batterie 5000mAh'],
                'images' => ['https://via.placeholder.com/500x500/3498db/ffffff?text=S23+Ultra'],
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'smartphones')->first()->id
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Dernier iPhone avec puce A17 Pro et design en titane.',
                'price' => 850000,
                'compare_price' => 900000,
                'stock' => 10,
                'sku' => 'APP-15P-001',
                'brand' => 'Apple',
                'features' => ['Écran 6.1"', '128GB Stockage', 'Chip A17 Pro', 'Titane'],
                'images' => ['https://via.placeholder.com/500x500/95a5a6/ffffff?text=iPhone+15+Pro'],
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'smartphones')->first()->id
            ],

            // Tablettes
            [
                'name' => 'iPad Air 5',
                'slug' => 'ipad-air-5',
                'description' => 'Tablette Apple performante avec puce M1 et écran Liquid Retina.',
                'price' => 550000,
                'compare_price' => 600000,
                'stock' => 8,
                'sku' => 'APP-IPA5-001',
                'brand' => 'Apple',
                'features' => ['Écran 10.9"', '64GB Stockage', 'Chip M1', 'Support Apple Pencil'],
                'images' => ['https://via.placeholder.com/500x500/e74c3c/ffffff?text=iPad+Air'],
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'tablettes')->first()->id
            ],
            [
                'name' => 'Samsung Tab S9',
                'slug' => 'samsung-tab-s9',
                'description' => 'Tablette Android premium avec écran Dynamic AMOLED et S Pen inclus.',
                'price' => 480000,
                'compare_price' => 520000,
                'stock' => 12,
                'sku' => 'SM-TS9-001',
                'brand' => 'Samsung',
                'features' => ['Écran 11"', '128GB Stockage', 'S Pen inclus', 'Batterie longue durée'],
                'images' => ['https://via.placeholder.com/500x500/2ecc71/ffffff?text=Tab+S9'],
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'tablettes')->first()->id
            ],

            // Laptops
            [
                'name' => 'MacBook Pro 14" M3',
                'slug' => 'macbook-pro-14-m3',
                'description' => 'Ordinateur portable professionnel avec puce M3 et écran Liquid Retina XDR.',
                'price' => 2500000,
                'compare_price' => 2700000,
                'stock' => 5,
                'sku' => 'APP-MBP14-001',
                'brand' => 'Apple',
                'features' => ['Écran 14.2"', '512GB SSD', '16GB RAM', 'Chip M3'],
                'images' => ['https://via.placeholder.com/500x500/34495e/ffffff?text=MacBook+Pro'],
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'laptops')->first()->id
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Ultrabook compact avec écran InfinityEdge et processeur Intel Core i7.',
                'price' => 1200000,
                'compare_price' => 1350000,
                'stock' => 7,
                'sku' => 'DEL-XPS13-001',
                'brand' => 'Dell',
                'features' => ['Écran 13.4"', '512GB SSD', '16GB RAM', 'Intel Core i7'],
                'images' => ['https://via.placeholder.com/500x500/9b59b6/ffffff?text=XPS+13'],
                'is_featured' => false,
                'category_id' => $categories->where('slug', 'laptops')->first()->id
            ],

            // Accessoires
            [
                'name' => 'AirPods Pro 2',
                'slug' => 'airpods-pro-2',
                'description' => 'Écouteurs sans fil avec réduction de bruit active et boîtier MagSafe.',
                'price' => 180000,
                'compare_price' => 200000,
                'stock' => 25,
                'sku' => 'APP-APP2-001',
                'brand' => 'Apple',
                'features' => ['Réduction de bruit', 'Autonomie 6h', 'Boîtier MagSafe', 'Résistance à l\'eau'],
                'images' => ['https://via.placeholder.com/500x500/f39c12/ffffff?text=AirPods+Pro'],
                'is_featured' => true,
                'category_id' => $categories->where('slug', 'accessoires')->first()->id
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
