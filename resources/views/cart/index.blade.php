<x-layout>
  <div class="container py-5">
    <h1 class="mb-4">
      <i class="bi bi-cart-fill me-2"></i> {{ __('ui.navbarCart') }}
    </h1>

    @if (session('successMessage'))
      <div class="alert alert-success">
        {{ session('successMessage') }}
      </div>
    @endif

    @if (count($cart) > 0)
      <ul class="list-group mb-4">
        @foreach ($cart as $articleId)
          @php
            $article = \App\Models\Article::find($articleId);
            $translation = $article?->translation();
          @endphp

          @if ($article)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong>{{ $translation->title ?? $article->title }}</strong><br>
                <small>{{ $translation->description ?? $article->description }}</small>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="fw-bold">{{ $article->price }} €</span>
                <form action="{{ route('cart.remove') }}" method="POST">
                  @csrf
                  <input type="hidden" name="article_id" value="{{ $article->id }}">
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </li>
          @endif
        @endforeach
      </ul>

      {{-- Checkout fittizio --}}
      <div class="text-end">
        <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#checkoutForm" aria-expanded="false" aria-controls="checkoutForm">
          <i class="bi bi-credit-card-fill me-1"></i> {{ __('ui.checkoutButton') }}
        </button>
      </div>

      <div class="collapse mt-4" id="checkoutForm">
        <div class="card card-body">
          <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="cardName" class="form-label">Nome sulla carta</label>
              <input type="text" class="form-control" id="cardName" name="card_name" required>
            </div>

            <div class="mb-3">
              <label for="cardNumber" class="form-label">Numero carta</label>
              <input type="text" class="form-control" id="cardNumber" name="card_number" required maxlength="19" placeholder="1234 5678 9012 3456">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="expiry" class="form-label">Scadenza</label>
                <input type="text" class="form-control" id="expiry" name="expiry" required placeholder="MM/AA">
              </div>
              <div class="col-md-6 mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required maxlength="4">
              </div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Conferma pagamento
              </button>
            </div>
          </form>
        </div>
      </div>
    @else
      <div class="alert alert-info text-center">
        <i class="bi bi-cart-x-fill me-2"></i> {{ __('ui.emptyCartMessage') }}
      </div>
    @endif
  </div>
</x-layout>
