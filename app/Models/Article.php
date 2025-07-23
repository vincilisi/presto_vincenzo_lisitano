<?php

namespace App\Models;

use App\Models\Image;
use App\Models\User;
use App\Models\Category;
use App\Models\ArticleTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title', 'description', 'price', 'category_id', 'user_id'
    ];

    protected $casts = [
        'labels' => 'array',
    ];

    // 🔗 Relazione con l'utente
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relazione con la categoria
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // 🔗 Relazione con le immagini
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    // 🔗 Relazione con le traduzioni
    public function translations(): HasMany
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    // 🔍 Ottieni la traduzione nella lingua attiva
    public function translation($locale = null): ?ArticleTranslation
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->where('locale', $locale)->first();
    }

    // ✅ Imposta lo stato di accettazione
    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this->save();
        return true;
    }

    // 📊 Conta gli articoli da revisionare
    public static function toBeRevisedCount()
    {
        return Article::where('is_accepted', null)->count();
    }

    // 🔎 Array per la ricerca con Laravel Scout
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category ? $this->category->name : null,
        ];
    }

    // 🔍 Ricerca articoli tramite query
    public function searchArticles(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::search($query)->where('is_accepted', true)->paginate(10);
        return view('article.searched', ['articles' => $articles, 'query' => $query]);
    }
}
