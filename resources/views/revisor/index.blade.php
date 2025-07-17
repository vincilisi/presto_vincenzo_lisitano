<x-layout>
    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="rounded shadow bg-body-secondary">
                    <h1 class="display-5 text-center pb-2">
                        {{ __('ui.revisorDashboard') }}
                    </h1>
                </div>
            </div>
            <div class="col"></div>
        </div>

        @if(isset($article_to_check) && $article_to_check)
            <div class="row justify-content-center pt-5">
                <div class="col-md-8">

                    {{-- Toggle per mostrare/nascondere analisi AI --}}
                    <div class="form-check form-switch mb-4 text-end">
                        <input class="form-check-input" type="checkbox" id="toggleAnalysis" checked>
                        <label class="form-check-label" for="toggleAnalysis">
                            {{ __('ui.showAnalysis') }}
                        </label>
                    </div>

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

                                            {{-- Blocchi analisi AI --}}
                                            <div class="col-md-5 p-3 analysis-block">
                                                <h5>{{ __('ui.labels') }}</h5>
                                                @if (is_array($image->labels) && count($image->labels))
                                                    @foreach ($image->labels as $label)
                                                        <p class="mb-1">{{ $label }}</p>
                                                    @endforeach
                                                @else
                                                    <p class="fst-italic">{{ __('ui.noLabels') }}</p>
                                                @endif
                                            </div>

                                            <div class="col-md-3 p-3 analysis-block">
                                                <h5>{{ __('ui.ratings') }}</h5>
                                                @php
                                                    $ratings = [
                                                        'adult' => $image->adult_class ?? 'bg-secondary',
                                                        'violence' => $image->violence_class ?? 'bg-secondary',
                                                        'spoof' => $image->spoof_class ?? 'bg-secondary',
                                                        'racy' => $image->racy_class ?? 'bg-secondary',
                                                        'medical' => $image->medical_class ?? 'bg-secondary',
                                                    ];
                                                @endphp
                                                @foreach ($ratings as $label => $class)
                                                    <div class="row justify-content-center mb-1">
                                                        <div class="col-2">
                                                            <div class="rounded-circle {{ $class }} w-100" style="height: 20px;"></div>
                                                        </div>
                                                        <div class="col-10 text-capitalize">{{ $label }}</div>
                                                    </div>
                                                @endforeach
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

                    @if(session()->has('message'))
                        <div class="row justify-content-center">
                            <div class="col-5 alert alert-success text-center shadow rounded">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Informazioni articolo + bottoni --}}
                <div class="col-md-4 ps-4 d-flex flex-column justify-content-between">
                    <div>
                        <h3>{{ $article_to_check->title }}</h3>
                        <h3>{{ __('ui.author') }}: {{ $article_to_check->user?->name ?? __('ui.anonymous') }}</h3>
                        <h4>{{ __('ui.published') }}: {{ $article_to_check->expire ?? __('ui.dateUnavailable') }}</h4>
                        <h4 class="fst-italic text-muted">
                            {{ $article_to_check->category?->name ?? __('ui.noCategory') }}
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

    {{-- Script toggle analisi AI --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('toggleAnalysis');
            const blocks = document.querySelectorAll('.analysis-block');

            toggle.addEventListener('change', function () {
                blocks.forEach(block => {
                    block.style.display = this.checked ? 'block' : 'none';
                });
            });
        });
    </script>
    @endpush
</x-layout>
