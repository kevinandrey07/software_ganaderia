@extends('layouts.app')

@section('content')
<div class="flex-grow flex items-center justify-center h-screen">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 bg-gray-800 bg-opacity-75">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h2 class="mb-0">{{ __('Login') }}</h2>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Campo Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label text-gray-200">{{ __('Email Address') }}</label>
                                <input id="email" type="email" 
                                       class="form-control rounded-pill @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                       style="border-color: #6b7280; padding: 10px; background-color: #374151; color: #e5e7eb;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label text-gray-200">{{ __('Password') }}</label>
                                <input id="password" type="password" 
                                       class="form-control rounded-pill @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password" 
                                       style="border-color: #6b7280; padding: 10px; background-color: #374151; color: #e5e7eb;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Checkbox Recordarme -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                           id="remember" {{ old('remember') ? 'checked' : '' }} 
                                           style="border-color: #16a34a;">
                                    <label class="form-check-label text-gray-200" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" 
                                        class="btn text-white px-4 py-2" 
                                        style="background-color: #16a34a; border-radius: 20px;"
                                        onmouseover="this.style.backgroundColor='#15803d'" 
                                        onmouseout="this.style.backgroundColor='#16a34a'">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-success" 
                                       href="{{ route('password.request') }}" 
                                       style="text-decoration: none;">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection