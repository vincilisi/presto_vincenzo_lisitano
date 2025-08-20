<x-layout>
<div class="container py-5">
    <h1 class="text-center mb-5">{{ __('ui.settings') }}</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- Aggiorna dati --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card p-4 shadow rounded">
                <h4 class="mb-3">{{ __('ui.profileSettings') }}</h4>
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('ui.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="text-danger fst-italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('ui.email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="text-danger fst-italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('ui.address') }}</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
                        @error('address')
                            <p class="text-danger fst-italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark">{{ __('ui.saveChanges') }}</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Aggiorna password --}}
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow rounded">
                <h4 class="mb-3">{{ __('ui.changePassword') }}</h4>
                <form action="{{ route('settings.updatePassword') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{ __('ui.currentPassword') }}</label>
                        <input type="password" name="current_password" id="current_password" class="form-control">
                        @error('current_password')
                            <p class="text-danger fst-italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('ui.newPassword') }}</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <p class="text-danger fst-italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('ui.confirmPassword') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-dark">{{ __('ui.updatePassword') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layout>
