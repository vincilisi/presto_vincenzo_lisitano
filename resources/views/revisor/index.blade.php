<x-layout>
    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-3">
                <div class="rounded shadow bg-body-secondary">
                    <h1 class="display-5 text-center pb-2">
                        {{ __('ui.revisorDashboard') }}
                    </h1>
                </div>
            </div>
            <div class="col"></div>
        </div>

        @if ($article_to_check)
            <div class="row justify-content-center pt-5">
                <div class="col-md-8">
                    <div class="row justify-content-center">
                        @if ($article_to_check->images->count())
                            @foreach ($article_to_check->images as $key => $image)
                                <div class="col-12 col-md-10 mb-5">
                                    <div class="card shadow">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{ Storage::url($image->path) }}"
                                                     class="img-fluid rounded-start"
                                                     alt="{{ __('ui.imageOfArticle', ['num' => $key + 1, 'title' => $article_to_check->title]) }}">
                                            </div>
                                            <div class="col-md-5 p-3">
                                                <h5>Labels</h5>
                                                @if ($image->labels)
                                                    @foreach ($image->labels as $label)
                                                        <p class="mb-1">{{ $label }}</p>
                                                    @endforeach
                                                @else
                                                    <p class="fst-italic">No labels</p>
                                                @endif
                                            </div>
                                            <div class="col-md-3 p-3">
                                                <h5>Ratings</h5>
                                                <div class="row justify-content-center mb-1">
                                                    <div class="col-2">
                                                        <div class="text-center mx-auto {{ $image->adult }}"></div>
                                                    </div>
                                                    <div class="col-10">adult</div>
                                                </div>
                                                <div class="row justify-content-center mb-1">
                                                    <div class="col-2">
                                                        <div class="text-center mx-auto {{ $image->violence }}"></div>
                                                    </div>
                                                    <div class="col-10">violence</div>
                                                </div>
                                                <div class="row justify-content-center mb-1">
                                                    <div class="col-2">
                                                        <div class="text-center mx-auto {{ $image->spoof }}"></div>
                                                    </div>
                                                    <div class="col-10">spoof</div>
                                                </div>
                                                <div class="row justify-content-center mb-1">
                                                    <div class="col-2">
                                                        <div class="text-center mx-auto {{ $image->racy }}"></div>
                                                    </div>
                                                    <div class="col-10">racy</div>
                                                </div>
                                                <div class="row justify-content-center mb-1">
                                                    <div class="col-2">
                                                        <div class="text-center mx-auto {{ $image->medical }}"></div>
                                                    </div>
                                                    <div class="col-10">medical</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 6; $i++)
                                <div class="col-6 col-md-4 mb-4 text-center">
                                    <img src="https://picsum.photos/300"
                                         class="img-fluid rounded shadow"
                                         alt="{{ __('ui.placeholderImageAlt') }}">
                                </div>
                            @endfor
                        @endif
                    </div>

                    {{-- Bottoni di accettazione/rifiuto --}}
                    <div class="d-flex pb-4 justify-content-around">
                        <form action="{{ route('reject', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger py-2 px-5 fw-bold">
                                {{ __('ui.rejectButton') }}
                            </button>
                        </form>
                        <form action="{{ route('accept', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success py-2 px-5 fw-bold">
                                {{ __('ui.acceptButton') }}
                            </button>
                        </form>
                    </div>

                    {{-- Messaggio flash --}}
                    @if(session()->has('message'))
                        <div class="row justify-content-center">
                            <div class="col-5 alert alert-success text-center shadow rounded">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Informazioni articolo --}}
                <div class="col-md-4 ps-4 d-flex flex-column justify-content-between">
                    <div>
                        <h3>{{ $article_to_check->title }}</h3>
                        <h3>{{ __('ui.author') }}: {{ optional($article_to_check->user)->name ?? __('ui.anonymous') }}</h3>
                        <h4>{{ __('ui.published') }}: {{ $article_to_check->expire ?? __('ui.dateUnavailable') }}</h4>
                        <h4 class="fst-italic text-muted">
                            {{ optional($article_to_check->category)->name ?? __('ui.noCategory') }}
                        </h4>
                        <p class="h6">{{ $article_to_check->description }}</p>
                    </div>

                    <div class="d-flex pb-4 justify-content-around">
                        <form action="{{ route('reject', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger py-2 px-5 fw-bold">
                                {{ __('ui.rejectButton') }}
                            </button>
                        </form>
                        <form action="{{ route('accept', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success py-2 px-5 fw-bold">
                                {{ __('ui.acceptButton') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center align-items-center height-custom text-center">
                <div class="col-12">
                    <h1 class="fst-italic display-4">
                        {{ __('ui.noArticlesToReview') }}
                    </h1>
                    <a href="{{ route('homepage') }}" class="mt-5 btn btn-success">
                        {{ __('ui.backToHomepage') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
