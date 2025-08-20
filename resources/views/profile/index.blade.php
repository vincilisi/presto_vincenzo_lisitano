<x-layout>
  <div class="container py-5">
    <h1 class="mb-4">{{ __('ui.profileOf') }} {{ $user->name }}</h1>

    {{-- Avatar --}}
    <div class="mb-4">
      @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" width="150" height="150" alt="{{ __('ui.avatar') }}">
      @else
        <img src="https://via.placeholder.com/150" class="rounded-circle" alt="{{ __('ui.avatar') }}">
      @endif
    </div>

    {{-- Profilo incompleto o in modifica --}}
    @if($profileIncomplete || request('edit') == 1)
      <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <input type="file" name="avatar" class="form-control">
        </div>
        <button class="btn btn-primary">{{ __('ui.updateAvatar') }}</button>
      </form>

      <hr>

      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">{{ __('ui.name') }}</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
          <label class="form-label">{{ __('ui.email') }}</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
        <div class="mb-3">
          <label class="form-label">{{ __('ui.address') }}</label>
          <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>
        <button class="btn btn-success">{{ __('ui.saveProfile') }}</button>
      </form>
    @else
      {{-- Mostra dati salvati --}}
      <p><strong>{{ __('ui.name') }}:</strong> {{ $user->name }}</p>
      <p><strong>{{ __('ui.email') }}:</strong> {{ $user->email }}</p>
      <p><strong>{{ __('ui.address') }}:</strong> {{ $user->address }}</p>

      <a href="{{ route('profile', ['edit' => 1]) }}" class="btn btn-warning">
        {{ __('ui.editProfile') }}
      </a>
    @endif

    <hr>

    {{-- Articoli creati dall'utente --}}
    <h3>{{ __('ui.yourArticles') }}</h3>
    @if($user->articles->count())
      <div class="row">
        @foreach($user->articles as $article)
          @php
            $translation = $article->translation();
          @endphp
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              @if($article->images->count())
                <img src="{{ $article->images->first()->getUrl(300, 200) }}" class="card-img-top" alt="{{ $translation->title ?? $article->title }}">
              @else
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $translation->title ?? $article->title }}">
              @endif
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $translation->title ?? $article->title }}</h5>
                <p class="card-text">{{ $translation->description ?? $article->description }}</p>
                <p class="fw-bold">{{ $article->price }} €</p>
                <a href="{{ route('articles.show', $article) }}" class="btn btn-primary mt-auto">{{ __('ui.viewArticle') }}</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <p>{{ __('ui.noArticles') }}</p>
    @endif
  </div>
</x-layout>
