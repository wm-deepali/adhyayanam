@extends('layouts.app')

@section('title', 'Update Sub Admin Password')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Update Password</h5>

        <a href="{{ route('sub-admins.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>

    <div class="card-body">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sub-admins.password.update', $user->id) }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Sub Admin Name</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $user->first_name }} {{ $user->last_name }}"
                           disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $user->email }}"
                           disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">New Password <span class="text-danger">*</span></label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Update Password
                </button>

                <a href="{{ route('sub-admins.index') }}" class="btn btn-light ms-2">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div
