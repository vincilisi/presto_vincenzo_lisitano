<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\ResizeImage;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;   
use Livewire\Component;
use Livewire\WithFileUploads;

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
    public $article;
    public $images = [];
    public $temporary_images;

   public function store()
{
    $this->validate();

    // Crea l'articolo
    $article = Article::create([
        'title' => $this->title,
        'description' => $this->description,
        'price' => $this->price,
        'category_id' => $this->category,
        'user_id' => Auth::user()->id,
    ]);

    // Salva le immagini caricate
    if(count($this->image) >0)
    {
        foreach($this->images as $image)
        {
            $newFileName = 'article/{$this->article->id}';
            $newImage =$this->article->images()->create(['path => $image->store($newFileName', 'public']);
            dispatch(new ResizeImage($newImage->path, 300, 300));
            dispatch(new GoogleVisionSafeSearch($newImage->id));
            dispatch(new GoogleVisionLabelImage($newImage->id));
        }
        session()->flash('success', 'Articolo creato correttamente');
        $this->cleanForm();
    }
    
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
}

public function updatedTemporyImages()
{
    if($this->validate([
        'temporary_images.*' => 'image|max:1024',
        'temporary_images' => 'max:6'
    ])) {
        foreach($this->temporary_images as $image){
            $this->images [] = $image;
        }
    }
}

public function removeImage($key)
{
    if(in_array($key, array_keys($this->images)))
    {
        unset($this->images[$key]);
    }
}

}
