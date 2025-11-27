<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Smartphone et mobiles',
                'image' => 'https://via.placeholder.com/300x200/3498db/ffffff?text=Smartphones'
            ],
            [
                'name' => 'Tablettes',
                'slug' => 'tablettes',
                'description' => 'Tablettes tactiles et iPad',
                'image' => 'https://via.placeholder.com/300x200/e74c3c/ffffff?text=Tablettes'
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Ordinateurs portables et ultrabooks',
                'image' => 'https://via.placeholder.com/300x200/2ecc71/ffffff?text=Laptops'
            ],
            [
                'name' => 'Accessoires',
                'slug' => 'accessoires',
                'description' => 'Accessoires et périphériques',
                'image' => 'https://via.placeholder.com/300x200/f39c12/ffffff?text=Accessoires'
            ],
            [
                'name' => 'Écrans',
                'slug' => 'ecrans',
                'description' => 'Moniteurs et écrans d\'ordinateur',
                'image' => 'https://via.placeholder.com/300x200/9b59b6/ffffff?text=Écrans'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
