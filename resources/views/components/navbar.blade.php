<nav class="navbar navbar-expand-lg bg-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">{{ __('ui.title') }}</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="{{ __('ui.toggleNavigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        {{-- Home --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
             href="{{ route('homepage') }}">{{ __('ui.navbarHome') }}</a>
        </li>

        {{-- Articoli --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('article.index') ? 'active' : '' }}"
             href="{{ route('article.index') }}">{{ __('ui.navbarArticles') }}</a>
        </li>

        {{-- Categoria Dropdown --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             {{ __('ui.navbarCategories') }}
          </a>
          <ul class="dropdown-menu">
            @foreach ($categories as $category)
              <li>
                <a class="dropdown-item text-capitalize"
                   href="{{ route('byCategory', ['category' => $category->id]) }}">
                   {{ __('category.' . Str::slug($category->name, '_')) }}
                </a>
              </li>
              @if (! $loop->last)
                <li><hr class="dropdown-divider"></li>
              @endif
            @endforeach
          </ul>
        </li>

        {{-- Revisore --}}
        @auth
          @if (Auth::user()->is_revisor)
            <li class="nav-item position-relative">
              <a class="nav-link btn btn-outline-success btn-sm"
                 href="{{ route('revisor.index') }}">
                 {{ __('ui.navbarReviewerZone') }}
                 <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                   {{ \App\Models\Article::toBeRevisedCount() }}
                 </span>
              </a>
            </li>
          @endif
        @endauth

        {{-- Utente --}}
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               {{ __('ui.navbarHelloUser', ['name' => Auth::user()->name]) }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('create.article') }}">{{ __('ui.navbarCreate') }}</a></li>
              <li><a class="dropdown-item" href="#">{{ __('ui.navbarProfile') }}</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">{{ __('ui.navbarSettings') }}</a></li>
              <li>
                <a class="dropdown-item" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   {{ __('ui.navbarLogout') }}
                </a>
              </li>
            </ul>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               {{ __('ui.navbarHelloUser', ['name' => __('ui.navbarGuest')]) }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('ui.navbarLogin') }}</a></li>
              <li><a class="dropdown-item" href="{{ route('register') }}">{{ __('ui.navbarRegister') }}</a></li>
            </ul>
          </li>
        @endauth
      </ul>

      {{-- Bandiere --}}
      @php $langs = ['it','en','ja','fr','de','es']; @endphp
      @foreach ($langs as $lang)
        <x-_locale :lang="$lang" />
      @endforeach

      {{-- Ricerca --}}
      <form class="d-flex ms-auto" role="search" action="{{ route('article.search') }}" method="GET">
        <div class="input-group">
          <input type="search" name="query" class="form-control" placeholder="{{ __('ui.searchPlaceholder') }}" aria-label="search">
          <button type="submit" class="input-group-text btn btn-outline-success">
            {{ __('ui.searchButton') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</nav>
