<?php

namespace App\Jobs;

use Spatie\Image\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\CropPosition;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    private $w, $h, $fileName, $path;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $w, $h)
    {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w =$w;
        $this->h = $h;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $w = $this->w;
       $h = $this->h;
       $srcPath = storage_path() . '/app/public' . '/' . $this->fileName;
       $destPath = storage_path() . '/app/public' . '/crop_{$w}x{$h}_' . $this->fileName;

       Image::load($srcPath)
                ->crop($w, $h, CropPosition::Center)
                ->save($destPath);
    }
}
