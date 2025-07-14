<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Article;

class Image extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'path'
    ];

    public function article() : BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
