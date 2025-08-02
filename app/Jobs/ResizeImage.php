<?php

namespace App\Jobs;

use Spatie\Image\Image;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Enums\CropPosition;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResizeImage implements ShouldQueue
{
    use Queueable;

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
        $srcPath = storage_path("app/public/{$this->path}/{$this->fileName}");
        $destFileName = "crop_{$this->w}x{$this->h}_{$this->fileName}";
        $destPath = storage_path("app/public/{$this->path}/{$destFileName}");

        $watermarkPath = base_path('resources/img/watermark.png');

        $image = Image::load($srcPath)
            ->crop($this->w, $this->h, CropPosition::Center);

        if (file_exists($watermarkPath)) {
            $image->watermark($watermarkPath);
        }

        $image->save($destPath);
    }
}
