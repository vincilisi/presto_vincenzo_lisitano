<x-layout>
    <div class="container-fluid text-center bg-body-teertiary">
        <div class="col-12">
            <h1 class="display-4">Presto.it</h1>
        </div>
        <div class="my-3">
            @auth
            <a href="{{route('create.article')}}" class="btn btn-dark">Publica il tuo Articolo</a>
            @endauth
        </div>
    </div>
</x-layout>