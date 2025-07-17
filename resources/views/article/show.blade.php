<x-layout>
  <div class="container">
    @php
      $translation = $article->translation();
    @endphp

    <div class="row height-custom justify-content-center align-items-center text-center">
      <div class="col-12">
        <h1 class="display-4">
          {{ __('ui.detailTitle') }}: {{ $translation->title }}
        </h1>
      </div>
    </div>

    <div class="row height-custom justify-content-center py-5">
      {{-- Carousel immagini --}}
      <div class="col-12 col-md-6 mb-3">
        <div id="carouselExample1" class="carousel slide">
          <div class="carousel-inner">
            @foreach ($article->images as $key => $image)
              <div class="carousel-item @if($loop->first) active @endif">
                <img src="{{ $image->getUrl(300,300) }}"
                     alt="{{ __('ui.imageOfArticle', ['num' => $key + 1, 'title' => $translation->title]) }}"
                     class="d-block w-100 rounded shadow">
              </div>
            @endforeach
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('ui.previous') }}</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('ui.next') }}</span>
          </button>
        </div>
      </div>

      {{-- Dettagli articolo --}}
      <div class="col-12 col-md-6 mb-3 height-custom text-center">
        <h2 class="display-5">
          <span class="fw-bold">{{ __('ui.detailTitle') }}: </span> {{ $translation->title }}
        </h2>
        <div class="d-flex flex-column justify-content-center h-75">
          <h4 class="fw-bold">
            {{ __('ui.detailPrice') }}: {{ $article->price }} €
          </h4>
          <h5>{{ __('ui.detailDescription') }}:</h5>
          <p>{{ $translation->description }}</p>
        </div>
      </div>
    </div>
  </div>
  <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
  @csrf
  <input type="hidden" name="article_id" value="{{ $article->id }}">
  <button type="submit" class="btn btn-primary">
    <i class="bi bi-cart-plus"></i> {{ __('ui.addToCartButton') }}
  </button>
</form>

</x-layout>
