<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;

class RemoveFaces implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $article_image_id;

    public function __construct($article_image_id)
    {
        $this->article_image_id = $article_image_id;
    }

    public function handle(): void
    {
        $imageRecord = Image::find($this->article_image_id);
        if (!$imageRecord) {
            Log::warning("Immagine non trovata con ID: {$this->article_image_id}");
            return;
        }

        $srcPath = storage_path('app/public/' . $imageRecord->path);
        if (!file_exists($srcPath)) {
            Log::error("File immagine non trovato in: $srcPath");
            return;
        }

        $imageContent = file_get_contents($srcPath);

        try {
            $imageAnnotator = new ImageAnnotatorClient();
            $response = $imageAnnotator->faceDetection($imageContent);
            $faces = $response->getFaceAnnotations();
        } catch (\Throwable $e) {
            Log::error("Errore nel rilevamento volti: " . $e->getMessage());
            return;
        }

        if (count($faces) === 0) {
            Log::info("Nessuna faccia rilevata per immagine ID: {$this->article_image_id}");
            $imageAnnotator->close();
            return;
        }

        // Carica l'immagine originale con Intervention Image
        $image = Image::make($srcPath);

        foreach ($faces as $face) {
            $vertices = $face->getBoundingPoly()->getVertices();

            $bounds = [];
            foreach ($vertices as $vertex) {
                $bounds[] = [$vertex->getX() ?? 0, $vertex->getY() ?? 0];
            }

            if (count($bounds) < 3) continue;

            $xs = array_column($bounds, 0);
            $ys = array_column($bounds, 1);

            $x = min($xs);
            $y = min($ys);
            $w = max(1, max($xs) - $x);
            $h = max(1, max($ys) - $y);

            // Carica il watermark, ridimensionandolo per coprire il volto
            $watermark = Image::make(base_path('resources/img/smile.png'))
                ->resize($w, $h);

            // Inserisci il watermark nell'immagine, posizionato esattamente sul volto
            $image->insert($watermark, 'top-left', $x, $y);
        }

        // Salva sovrascrivendo il file originale
        $image->save($srcPath);

        $imageAnnotator->close();

        Log::info("Faccine coperte con smile su immagine ID: {$this->article_image_id}");
    }
}
