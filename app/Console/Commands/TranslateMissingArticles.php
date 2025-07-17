<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateMissingArticles extends Command
{
    protected $signature = 'translate:missing';
    protected $description = 'Genera traduzioni mancanti per gli articoli';

    public function handle()
    {
        $languages = ['it', 'en', 'es', 'fr', 'ja', 'de'];
        $articles = Article::all();

        $this->info("🔍 Controllo articoli...");

        foreach ($articles as $article) {
            foreach ($languages as $lang) {
                $exists = $article->translations()->where('locale', $lang)->exists();

                if (! $exists) {
                    $this->line("🌐 Traduzione mancante per articolo #{$article->id} in [$lang]...");

                    $translator = new GoogleTranslate($lang);

                    try {
                        $translatedTitle = $translator->translate($article->title);
                        $translatedDescription = $translator->translate($article->description);

                        $article->translations()->create([
                            'locale' => $lang,
                            'title' => $translatedTitle,
                            'description' => $translatedDescription,
                        ]);

                        $this->info("✅ Tradotto in [$lang]");
                    } catch (\Exception $e) {
                        $this->error("❌ Errore per [$lang]: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info("🎉 Traduzioni completate!");
    }
}
