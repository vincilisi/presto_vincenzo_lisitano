<?php

namespace App\Jobs;

use Spatie\Image\Image;
use Spatie\Image\Enums\CropPosition;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    private $w, $h, $fileName, $path;

    public function __construct($filePath, $w, $h)
    {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $w = $this->w;
        $h = $this->h;

        $srcPath = storage_path("app/public/{$this->path}/{$this->fileName}");
        $destFileName = "crop_{$w}x{$h}_{$this->fileName}";
        $destPath = storage_path("app/public/{$this->path}/{$destFileName}");

        $watermarkPath = base_path('resources/img/watermark.png');

        $image = Image::load($srcPath)
            ->crop($w, $h, CropPosition::Center);

        // Aggiunge solo il watermark se il file esiste
        if (file_exists($watermarkPath)) {
            $image->watermark($watermarkPath); // Nessuna posizione personalizzata disponibile
        }

        $image->save($destPath);
    }
}
