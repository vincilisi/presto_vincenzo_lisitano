<?php

namespace App\Jobs;

use App\Models\Image;
use Spatie\Image\Enums\Fit;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Enums\AlignPosition;
use Illuminate\Queue\SerializesModels;
use Spatie\Image\Image as SpatieImage;
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
            Log::warning("message");("Immagine non trovata con ID: {$this->article_image_id}");
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

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $image = SpatieImage::load($srcPath);

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

            $tempWatermarkPath = $tempDir . '/watermark_' . uniqid() . '.png';

            try {
                SpatieImage::load(base_path('resources/img/smile.png'))
                    ->fit(Fit::Stretch, $w, $h)
                    ->save($tempWatermarkPath);

                $image->watermark(
    $tempWatermarkPath,
    position: AlignPosition::TopLeft,
    paddingX: $x,
    paddingY: $y
);

            } finally {
                if (file_exists($tempWatermarkPath)) {
                    unlink($tempWatermarkPath);
                }
            }
        }

        $image->save($srcPath);
        $imageAnnotator->close();

        Log::info("Faccine coperte con smile su immagine ID: {$this->article_image_id}");
    }
}
