@extends('layouts.app')

@section('content')
    <div class="flex-grow flex items-center justify-center h-screen">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6"> <!-- Reduje de col-md-8 a col-md-6 para coherencia con el login -->
                    <div class="card shadow-lg border-0 bg-gray-800 bg-opacity-75">
                        <div class="card-header bg-success text-white text-center py-3">
                            <h2 class="mb-0">{{ __('Register') }}</h2>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Campo Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label text-gray-200">{{ __('Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control rounded-pill @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        style="border-color: #6b7280; padding: 10px; background-color: #374151; color: #e5e7eb;">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Campo Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label text-gray-200">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control rounded-pill @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
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
                                        name="password" required autocomplete="new-password"
                                        style="border-color: #6b7280; padding: 10px; background-color: #374151; color: #e5e7eb;">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Campo Confirm Password -->
                                <div class="mb-3">
                                    <label for="password-confirm"
                                        class="form-label text-gray-200">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control rounded-pill"
                                        name="password_confirmation" required autocomplete="new-password"
                                        style="border-color: #6b7280; padding: 10px; background-color: #374151; color: #e5e7eb;">
                                </div>

                                <!-- Botón -->
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn text-white px-4 py-2"
                                        style="background-color: #16a34a; border-radius: 20px;"
                                        onmouseover="this.style.backgroundColor='#15803d'"
                                        onmouseout="this.style.backgroundColor='#16a34a'">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #16a34a !important;
            box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.25) !important;
        }
    </style>
@endsection
