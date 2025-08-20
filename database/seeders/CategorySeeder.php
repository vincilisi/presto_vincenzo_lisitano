<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'elettronica',
            'abbigliamento',
            'salute-e-bellezza',
            'casa-e-giardinaggio',
            'giocattoli',
            'sport',
            'accessori',
            'motori',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
