<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
use App\Jobs\ResizeImage;
use App\Models\Article;
use App\Models\ArticleTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    #[Validate('required|min:5')]
    public $title;

    #[Validate('required|min:10')]
    public $description;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('required')]
    public $category;

    public $images = [];
    public $temporary_images = [];

    public function store()
    {
        $this->validate();

        // Crea l'articolo
        $article = Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id(),
        ]);

        // 🔁 Traduzione automatica in più lingue
        $languages = ['it', 'en', 'es', 'fr', 'ja', 'de'];

        foreach ($languages as $lang) {
            $translator = new GoogleTranslate($lang);

            $translatedTitle = $translator->translate($this->title);
            $translatedDescription = $translator->translate($this->description);

            $article->translations()->create([
                'locale' => $lang,
                'title' => $translatedTitle,
                'description' => $translatedDescription,
            ]);
        }

        // 📷 Salva le immagini caricate
        if (count($this->images) > 0) {
            foreach ($this->images as $image) {
                $newFileName = "article/{$article->id}";
                $storedPath = $image->store($newFileName, 'public');

                $newImage = $article->images()->create([
                    'path' => $storedPath,
                ]);

                // 🧠 Esegui le job in catena
                RemoveFaces::withChain([
                    new ResizeImage($newImage->path, 300, 300),
                    new GoogleVisionSafeSearch($newImage->id),
                    new GoogleVisionLabelImage($newImage->id),
                ])->dispatch($newImage->id);
            }

            // 🧹 Elimina i file temporanei
            File::deleteDirectory(storage_path('app/livewire-tmp'));
        }

        session()->flash('success', 'Articolo creato correttamente');
        $this->cleanForm();
    }

    public function render()
    {
        return view('livewire.create-article-form');
    }

    public function cleanForm()
    {
        $this->title = '';
        $this->description = '';
        $this->price = '';
        $this->category = '';
        $this->images = [];
        $this->temporary_images = [];
    }

    public function updatedTemporaryImages()
    {
        $this->validate([
            'temporary_images.*' => 'image|max:1024',
            'temporary_images' => 'max:6',
        ]);

        foreach ($this->temporary_images as $image) {
            $this->images[] = $image;
        }
    }

    public function removeImage($key)
    {
        if (array_key_exists($key, $this->images)) {
            unset($this->images[$key]);
            $this->images = array_values($this->images); // Reindicizza
        }
    }
}
