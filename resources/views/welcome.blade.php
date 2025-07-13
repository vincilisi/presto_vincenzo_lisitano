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
    <div class="row height-custom justify-content-center align-items-center py-5">
        @forelse ($articles as $article)
            <div class="col-12 col-md-3">
             <x-card :article="$article" />
            </div>
        @empty
            <div class="col-12">
                <h3 class="text-center">
                    Non sono ancora stati creati articoli
                </h3>
             </div>
        @endforelse
    </div>
</x-layout>