@extends('layouts.guest')

@section('content')
    <div class="col-lg-8">
        <div class="card-group d-block d-md-flex row">
            <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                    <h1>{{ __('Teacher Login') }}</h1>
                    @include('layouts.includes.errors')
                    <form action="{{ route('teacher.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                                    </svg>
                                </span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="Enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                                    </svg>
                                </span>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    placeholder="Enter your password">
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                            @if (Route::has('teacher.password.request'))
                                <a href="{{ route('teacher.password.request') }}" class="btn btn-link">Forgot Your Password?</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const passwordIcon = document.querySelector('#passwordIcon');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the Font Awesome eye/eye-slash classes
        if (type === 'text') {
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    });
});


    </script>
@endsection