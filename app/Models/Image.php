<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'labels',
        'adult',
        'violence',
        'spoof',
        'racy',
        'medical',
    ];

    protected $casts = [
        'labels' => 'array',
    ];

    // 🔗 Relazione con l'articolo
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    // 🔍 Ottieni il percorso croppato
    public function getCroppedPath($w, $h)
    {
        $path = dirname($this->path);
        $filename = basename($this->path);
        return "{$path}/crop_{$w}x{$h}_{$filename}";
    }

    // 🌐 Ottieni l'URL dell'immagine (croppata o originale)
    public function getUrl($w = null, $h = null)
    {
        if (!$w && !$h) {
            return Storage::url($this->path);
        }

        $cropped = $this->getCroppedPath($w, $h);

        if (Storage::disk('public')->exists($cropped)) {
            return Storage::url($cropped);
        }

        if (Storage::disk('public')->exists($this->path)) {
            return Storage::url($this->path);
        }

        // 🧱 Fallback segnaposto
        return 'https://via.placeholder.com/' . ($w ?? 300);
    }

    // 🎨 Accessor per classi CSS dinamiche
    public function getAdultClassAttribute()
    {
        return $this->mapRatingToClass($this->adult);
    }

    public function getViolenceClassAttribute()
    {
        return $this->mapRatingToClass($this->violence);
    }

    public function getSpoofClassAttribute()
    {
        return $this->mapRatingToClass($this->spoof);
    }

    public function getRacyClassAttribute()
    {
        return $this->mapRatingToClass($this->racy);
    }

    public function getMedicalClassAttribute()
    {
        return $this->mapRatingToClass($this->medical);
    }

    // 🎯 Mappa i rating alle classi Bootstrap
    private function mapRatingToClass($rating)
    {
        return match($rating) {
            'VERY_LIKELY' => 'bg-danger',
            'LIKELY' => 'bg-warning',
            'UNLIKELY', 'VERY_UNLIKELY' => 'bg-success',
            'POSSIBLE' => 'bg-info',
            default => 'bg-secondary',
        };
    }
}
