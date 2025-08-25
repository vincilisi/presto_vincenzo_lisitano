<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'figurine-yokai',           // action figure e statuette
            'maschere-tradizionali',    // maschere di oni, tengu, kitsune
            'abiti-tradizionali',       // kimono, yukata, hakama
            'katana-e-accessori',       // repliche di spade e oggetti da samurai
            'oggetti-da-festival',      // lanterne, ventagli, decorazioni matsuri
            'gioielli-folclore',        // ciondoli, amuleti, charm
            'tazze-e-teiere',           // oggetti per tè e cerimonie
            'poster-e-arte-tradizionale' // stampe, quadri, illustrazioni
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
