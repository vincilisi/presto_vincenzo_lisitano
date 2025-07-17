<?php

namespace App\Console\Commands;

use App\Jobs\ResizeImage;
use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class VerifyAndResizeImages extends Command
{
    protected $signature = 'images:verify {--force}';
    protected $description = 'Verifica e rigenera le immagini croppate mancanti o tutte con --force';

    public function handle()
    {
        $width = 300;
        $height = 300;
        $force = $this->option('force');

        $this->info("🔍 Verifica immagini croppate {$width}x{$height}...");

        $images = Image::all();
        $count = 0;

        foreach ($images as $image) {
            $path = dirname($image->path);
            $filename = basename($image->path);
            $cropped = "{$path}/crop_{$width}x{$height}_{$filename}";

            $exists = Storage::disk('public')->exists($cropped);

            if ($force || ! $exists) {
                $action = $exists ? '♻️ Rigenerazione forzata' : '⚠️ Mancante';
                $this->line("$action: $cropped");

                ResizeImage::dispatch($image->path, $width, $height);
                $count++;
            }
        }

        $this->info("✅ Verifica completata. Immagini elaborate: $count");
    }
}
