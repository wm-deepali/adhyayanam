@extends('layouts.guest')

@section('content')
<div class="col-lg-6 mx-auto mt-5">
    <div class="card p-4">
        <h3 class="mb-4">Reset Your Password</h3>

        @include('layouts.includes.errors')

        <form method="POST" action="{{ route('teacher.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ $email ?? old('email') }}" 
                    required 
                    autofocus 
                    class="form-control"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    class="form-control @error('password') is-invalid @enderror"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input 
                    id="password-confirm" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    class="form-control"
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>
</div>
@endsection
