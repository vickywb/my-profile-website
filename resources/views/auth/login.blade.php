@extends('layouts.auth-app')

@section('title', 'Login Admin')
@section('content')

<div class="container py-5">
<div class="row justify-content-center">
    <div class="col-md-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">
        <h4 class="mb-3 text-center">Login</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" novalidate>
            @csrf

            <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" autofocus required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        </div>
    </div>
    </div>
</div>
</div>

    
@endsection