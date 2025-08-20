<?php

namespace App\Jobs;

use Spatie\Image\Image;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Enums\WatermarkPosition;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    private $w, $h, $fileName, $path;

    public function __construct($filePath, $w = 30, $h = 30)
    {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $w = 30;
        $h = 30;

        $srcPath = storage_path('app/public/' . $this->path . '/' . $this->fileName);
        $destPath = storage_path('app/public/' . $this->path . '/resized_' . $w . 'x' . $h . '_' . $this->fileName);

        Image::load($srcPath)
            ->resize($w, $h) // Ridimensiona l'immagine principale
            ->watermark(
                base_path('resources/img/watermark.png'),
                width: 10,
                height: 10,
                paddingX: 1,
                paddingY: 1,
            )
            ->save($destPath);
    }
}
