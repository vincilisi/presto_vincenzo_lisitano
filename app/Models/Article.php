<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'price', 'category_id', 'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this->save();
        return true;
    }

    public static function toBeRevisedCount()
    {
        return Article::where('is_accepted', null)->count();
    }

    public function toSearchableArray()
    {
        return [
            'id' =>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'category'=>$this->category
        ];
    }

    public function searchArticles(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::search($query)->where('is_accepted', true)->paginate(10);
        return view('article.searched', ['articles'=>$articles, 'query' =>$query]);
    }
}

