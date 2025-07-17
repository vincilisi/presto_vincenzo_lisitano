<?php

namespace App\Jobs;

use Spatie\Image\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Unit;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    private $w, $h, $fileName, $path;

    /**
     * Crea una nuova istanza del job.
     *
     * @param string $filePath Percorso relativo del file (es. article/10/nomefile.jpg)
     * @param int $w Larghezza desiderata
     * @param int $h Altezza desiderata
     */
    public function __construct($filePath, $w, $h)
    {
        $this->path = dirname($filePath);         // es: article/10
        $this->fileName = basename($filePath);    // es: nomefile.jpg
        $this->w = $w;
        $this->h = $h;
    }

    /**
     * Esegue il job: crop + watermark + salvataggio.
     */
    public function handle(): void
    {
        $w = $this->w;
        $h = $this->h;

        // Percorso sorgente
        $srcPath = storage_path("app/public/{$this->path}/{$this->fileName}");

        // Nome file croppato
        $destFileName = "crop_{$w}x{$h}_{$this->fileName}";

        // Percorso destinazione
        $destPath = storage_path("app/public/{$this->path}/{$destFileName}");

        // Esegui crop e watermark
        Image::load($srcPath)
            ->crop($w, $h, CropPosition::Center)
            ->watermark(
                base_path('resources/img/watermark.png'),
                width: 50,
                height: 50,
                paddingX: 5,
                paddingY: 5,
                paddingUnit: Unit::Percent
            )
            ->save($destPath);
    }
}
