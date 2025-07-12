<nav class="navbar navbar-expand-lg bg-light shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Presto.it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                @auth
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" role="botton" data-bs-toggle="dropdoen" aria-expanded="false">
                        Ciao, {{Auth:: user()-name}}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('create.article')}}" class="dropdown-item">Crea</a></li>
                        <li><a href="#" class="dropdown-item">Anothe action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="#" class="dropdown-item">Something else here</a></li>
                    </ul>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Ciao, Utente
                    </a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item" href="{{ route('login')}}">Accedi</a></li>
                        <li><a class="dropdown-item" href="{{ route('register')}}">Registrati</a></li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
