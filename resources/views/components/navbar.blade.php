<nav class="navbar navbar-expand-lg bg-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">
      <img src="{{ asset('image/logo.png') }}" alt="Logo" width="80" height="80" class="d-inline-block align-text-top">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="{{ __('ui.toggleNavigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse my-nav-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
             href="{{ route('homepage') }}">{{ __('ui.navbarHome') }}</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('article.index') ? 'active' : '' }}"
             href="{{ route('article.index') }}">{{ __('ui.navbarArticles') }}</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            {{ __('ui.navbarCategories') }}
          </a>
          <ul class="dropdown-menu">
            @foreach ($categories as $category)
              <li>
                <a class="dropdown-item text-capitalize"
                   href="{{ route('byCategory', ['category' => $category->id]) }}">
                   {{ __('category.' . Str::slug($category->name, '-')) }}
                </a>
              </li>
              @if (! $loop->last)
                <li><hr class="dropdown-divider"></li>
              @endif
            @endforeach
          </ul>
        </li>

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

        <li class="nav-item">
          <a class="nav-link position-relative" href="{{ route('cart.index') }}">
            🛒 {{ __('ui.navbarCart') }}
            @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
            @if ($cartCount > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
              </span>
            @endif
          </a>
        </li>
      </ul>

      {{-- Utente --}}
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ __('ui.navbarHelloUser', ['name' => Auth::user()->name]) }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
  <li><a class="dropdown-item" href="{{ route('create.article') }}">{{ __('ui.navbarCreate') }}</a></li>
  <li><a class="dropdown-item" href="{{ route('profile') }}">{{ __('ui.navbarProfile') }}</a></li>
  <li><a class="dropdown-item" href="{{ route('settings') }}">{{ __('ui.navbarSettings') }}</a></li>
  <li><hr class="dropdown-divider"></li>
  <li>
    <a class="dropdown-item" href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       {{ __('ui.navbarLogout') }}
    </a>
  </li>
</ul>

          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ __('ui.navbarHelloUser', ['name' => __('ui.navbarGuest')]) }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('ui.navbarLogin') }}</a></li>
              <li><a class="dropdown-item" href="{{ route('register') }}">{{ __('ui.navbarRegister') }}</a></li>
            </ul>
          </li>
        @endauth
      </ul>

      {{-- Lingue --}}
      @php
        $langs = ['it','en','ja','fr','de','es'];
        $langLabels = ['it' => 'IT', 'en' => 'EN', 'ja' => 'JP', 'fr' => 'FR', 'de' => 'DE', 'es' => 'ES'];
        $currentLang = app()->getLocale();
      @endphp
      <div class="dropdown mx-3">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                id="dropdownLanguage" data-bs-toggle="dropdown" aria-expanded="false">
          <x-_locale :lang="$currentLang" />
          <span class="ms-1">{{ strtoupper($currentLang) }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage">
          @foreach ($langs as $lang)
            @if ($lang !== $currentLang)
              <li>
                <form method="POST" action="{{ route('setLocale', $lang) }}">
                  @csrf
                  <button type="submit" class="dropdown-item d-flex align-items-center border-0 bg-transparent">
                    <x-_locale :lang="$lang" />
                    <span class="ms-2">{{ $langLabels[$lang] }}</span>
                  </button>
                </form>
              </li>
            @endif
          @endforeach
        </ul>
      </div>

      {{-- Ricerca --}}
      <form class="d-flex" role="search" action="{{ route('article.search') }}" method="GET">
        <div class="input-group">
          <input type="search" name="query" class="form-control" placeholder="{{ __('ui.searchPlaceholder') }}">
          <button type="submit" class="input-group-text btn btn-outline-success">
            {{ __('ui.searchButton') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</nav>
