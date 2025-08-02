<x-layout>
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="rounded shadow bg-body-secondary">
                    <h1 class="display-5 text-center pb-2">
                        {{ __("ui.dashboard") }}
                    </h1>
                </div>
            </div>
        </div>
        @if ($article_to_check)
        <div class="row justify-content-center pt-5">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    @if ($article_to_check->images->count())
                    @foreach ($article_to_check->images as $key => $image)
                    <div class="col-8">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $image->getUrl(300, 300) }}"
                                    class="img-fluid rounded-start"
                                    alt="Immagine {{ $key + 1 }} dell'articolo '{{ $article_to_check->title }}'">
                                </div>
                                <div class="col-md-5 ps-3">
                                    <div class="card-body">
                                        <h5>{{__("ui.Labels")}}</h5>
                                        @if ($image->labels)
                                        @foreach ($image->labels as $label)
                                        #{{ $label }},
                                        @endforeach
                                        @else
                                        <p class="fst-italic">{{__("ui.noLabels")}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body">
                                        <h5>{{__("ui.Ratings")}}</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="text-center mx-auto {{ $image->adult }}">
                                                </div>
                                            </div>
                                            <div class="col-10">{{__("ui.adult")}}</div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="text-center mx-auto {{ $image->violence }}">
                                                </div>
                                            </div>
                                            <div class="col-10">{{__("ui.violence")}}</div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="text-center mx-auto {{ $image->spoof }}">
                                                </div>
                                            </div>
                                            <div class="col-10">{{__("ui.spoof")}}</div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="text-center mx-auto {{ $image->racy }}">
                                                </div>
                                            </div>
                                            <div class="col-10">{{__("ui.racy")}}</div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="text-center mx-auto {{ $image->medical }}">
                                                </div>
                                            </div>
                                            <div class="col-10">{{__("ui.medical")}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                    @else
                    {{-- @for ($i = 0; $i < 6; $i++) --}}
                    <div class="col-6 col-md-4 mb-4 text-center">
                        <img src="https://picsum.photos/300" class="img-fluid rounded shadow" alt="Immagine segnaposto">
                    </div>
                    {{-- @endfor --}}
                    @endif
                </div>
            </div>
            <div class="col-md-4 ps-4 d-flex flex-column justify-content-between">
                <div>
                    <h1>{{ $article_to_check->title }}</h1>
                    <h3>{{ __("ui.author") }}: {{ $article_to_check->user->name }}</h3>
                    <h4>{{ $article_to_check->price }}€</h4>
                    <h4 class="fst-italic text-muted">#{{ __("ui." . $article_to_check->category->name) }}</h4>
                    <p class="h6">{{ $article_to_check->description }}</p>
                </div>
                <div class="d-flex pb-4 justify-content-around">
                    <form action="{{ route('reject', ['article' => $article_to_check]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger py-2 px-5 fw-bold">{{ __("ui.refuse") }}</button>
                    </form>
                    <form action="{{ route('accept', ['article' => $article_to_check]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success py-2 px-5 fw-bold">{{ __("ui.accept") }}</button>
                    </form>
                </div>
            </div>
            @if (session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-5 alert alert-success text-center shadow rounded">
                    {{ session('message') }}
                </div>
            </div>
            @endif
        </div>
        @else
        <div class="row justify-content-center align-items-center height-custom text-center">
            <div class="col-12">
                <h1 class="fst-italic display-4">
                    {{ __("ui.noRevision") }}
                </h1>
                <a href="{{ route('homepage') }}" class="mt-5 btn btn-success">{{ __("ui.backToHome") }}</a>
            </div>
        </div>
        @endif
    </div>
</x-layout>