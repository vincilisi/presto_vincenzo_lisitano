@php
    $image = $article->images->first();
@endphp

<div class="card mx-auto card-w shadow text-center mb-3">
    {{-- Immagine dell'articolo --}}
    <img src="{{ $image ? Storage::url($image->path) : 'https://picsum.photos/300' }}"
         class="card-img-top"
         alt="Immagine dell'articolo {{ $article->title }}">

    <div class="card-body">
        {{-- Titolo e prezzo --}}
        <h4 class="card-title">{{ $article->title }}</h4>
        <h6 class="card-subtitle text-body-secondary">{{ $article->price }} €</h6>

        {{-- Pulsanti --}}
        <div class="d-flex justify-content-evenly align-items-center mt-4">
            {{-- Pulsante Dettaglio --}}
            <a href="{{ route('articles.show', ['article' => $article]) }}" class="btn btn-primary">
                {{ __('ui.cardDetailButton') }}
            </a>

            {{-- Pulsante Categoria --}}
            @if ($article->category)
                <a href="{{ route('byCategory', ['category' => $article->category]) }}" class="btn btn-outline-info">
                    {{ __('category.' . Str::slug($article->category->name, '_')) }}
                </a>
            @else
                <span class="btn btn-outline-secondary disabled">
                    {{ __('ui.cardNoCategory') }}
                </span>
            @endif
        </div>
    </div>
</div>
