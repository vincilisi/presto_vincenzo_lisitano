<nav class="navbar navbar-expand-lg bg-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">Presto.it</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        
        {{-- Link Home --}}
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('homepage') }}">Home</a>
        </li>

        {{-- Link Articoli --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('article.index') }}">Articoli</a>
        </li>

        {{-- Utente autenticato --}}
        @auth
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ciao, {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="{{ route('create.article') }}" class="dropdown-item">Crea</a>
              </li>
              <li>
                <a href="#" class="dropdown-item">Profilo</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a href="#" class="dropdown-item">Impostazioni</a>
              </li>
            </ul>
          </li>
        @else
          {{-- Utente non autenticato --}}
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ciao, Utente
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="{{ route('login') }}">Accedi</a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('register') }}">Registrati</a>
              </li>
            </ul>
          </li>
        @endauth

        {{-- Menu Categoria --}}
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle"
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categoria
          </a>
          <ul class="dropdown-menu">
            @foreach ($categories as $category)
              <li>
                <a href="{{ route('byCategory', ['category' => $category->id]) }}"
                   class="dropdown-item text-capitalize">
                  {{ $category->name }}
                </a>
              </li>
              @if (! $loop->last)
                <li><hr class="dropdown-divider"></li>
              @endif
            @endforeach
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
