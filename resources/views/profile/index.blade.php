<x-layout>
    <div class="container py-5">
        <h1 class="mb-4">{{ __('Profilo di') }} {{ $user->name }}</h1>

        {{-- Avatar --}}
        <div class="mb-4">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" width="150" height="150">
            @else
                <img src="https://via.placeholder.com/150" class="rounded-circle" alt="Avatar">
            @endif
        </div>

        {{-- Modifica avatar --}}
        <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="avatar" class="form-control">
            </div>
            <button class="btn btn-primary">{{ __('Aggiorna Avatar') }}</button>
        </form>

        <hr>

        {{-- Modifica profilo --}}
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Nome') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Indirizzo') }}</label>
                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
            </div>
            <button class="btn btn-success">{{ __('Aggiorna Profilo') }}</button>
        </form>

        <hr>

        {{-- Ordini utente --}}
        <h3>{{ __('Storico ordini') }}</h3>
        @if(count($orders))
            <ul class="list-group">
                @foreach($orders as $order)
                    <li class="list-group-item">
                        Ordine #{{ $order->id }} - {{ $order->created_at->format('d/m/Y') }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('Nessun ordine disponibile') }}</p>
        @endif
    </div>
</x-layout>
