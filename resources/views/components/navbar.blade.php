<nav class="navbar navbar-expand-lg bg-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">Presto.it</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        {{-- Home --}}
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('homepage') }}">Home</a>
        </li>

        {{-- Articoli --}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('article.index') }}">Articoli</a>
        </li>

        {{-- Categoria Dropdown --}}
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle"
             role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

        {{-- Sezione utente --}}
        @auth
          @if (Auth::user()->is_revisor)
            {{-- Revisore --}}
            <li class="nav-item">
              <a class="nav-link btn btn-outline-success btn-sm position-relative"
                 href="{{ route('revisor.index') }}">Zona Revisore</a>
                 <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  {{ \App\Models\Article::toBeRevisedCount() }}
                 </span>
            </li>
          @endif

          {{-- Menu Utente Autenticato --}}
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Ciao, {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('create.article') }}">Crea</a></li>
              <li><a class="dropdown-item" href="#">Profilo</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Impostazioni</a></li>
            </ul>
          </li>
        @else
          {{-- Utente non autenticato --}}
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Ciao, Utente
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('login') }}">Accedi</a></li>
              <li><a class="dropdown-item" href="{{ route('register') }}">Registrati</a></li>
            </ul>
          </li>
        @endauth

      </ul>
    </div>
  </div>
</nav>
