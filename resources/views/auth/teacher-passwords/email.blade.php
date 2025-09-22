@extends('layouts.guest')

@section('content')
<div class="col-lg-6 mx-auto mt-5">
    <div class="card p-4">
        <h3 class="mb-4">Reset Teacher Password</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @include('layouts.includes.errors')

        <form method="POST" action="{{ route('teacher.password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    required autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
        </form>
    </div>
</div>
@endsection
