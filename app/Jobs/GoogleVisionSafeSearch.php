<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $article_image_id;

    public function __construct($article_image_id)
    {
        $this->article_image_id = $article_image_id;
    }

    public function handle(): void
    {
        $i = Image::find($this->article_image_id);
        if (!$i) {
            Log::warning("Immagine non trovata con ID: {$this->article_image_id}");
            return;
        }

        $path = storage_path('app/public/' . $i->path);
        if (!file_exists($path)) {
            Log::error("File immagine non trovato in: $path");
            return;
        }

        $imageContent = file_get_contents($path);

        $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');
        if (!file_exists($credentialsPath)) {
            Log::error("Credenziali Google Vision mancanti: $credentialsPath");
            return;
        }

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

        try {
            $imageAnnotator = new ImageAnnotatorClient();
            $response = $imageAnnotator->safeSearchDetection($imageContent);
            $imageAnnotator->close();
        } catch (\Throwable $e) {
            Log::error("Errore Vision API: " . $e->getMessage());
            return;
        }

        $safe = $response->getSafeSearchAnnotation();
        if (!$safe) {
            Log::info("SafeSearch vuoto per immagine ID: {$this->article_image_id}");
            return;
        }

        $likelihoodMap = [
            'text-secondary bi bi-circle-fill',             // UNKNOWN
            'text-success bi bi-check-circle-fill',         // VERY_UNLIKELY
            'text-success bi bi-check-circle-fill',         // UNLIKELY
            'text-warning bi bi-exclamation-circle-fill',   // POSSIBLE
            'text-warning bi bi-exclamation-circle-fill',   // LIKELY
            'text-danger bi bi-dash-circle-fill'            // VERY_LIKELY
        ];

        $i->adult    = $likelihoodMap[$safe->getAdult()]    ?? 'text-muted bi bi-question-circle';
        $i->spoof    = $likelihoodMap[$safe->getSpoof()]    ?? 'text-muted bi bi-question-circle';
        $i->racy     = $likelihoodMap[$safe->getRacy()]     ?? 'text-muted bi bi-question-circle';
        $i->medical  = $likelihoodMap[$safe->getMedical()]  ?? 'text-muted bi bi-question-circle';
        $i->violence = $likelihoodMap[$safe->getViolence()] ?? 'text-muted bi bi-question-circle';

        $i->save();

        Log::info("SafeSearch completato per immagine ID: {$this->article_image_id}");
    }
}
