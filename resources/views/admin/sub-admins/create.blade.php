@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Create Sub Admin</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('sub-admins.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mobile <span class="text-danger">*</span></label>
                <input type="text" name="mobile" class="form-control" required>
            </div>

            {{-- Password with Eye Toggle --}}
            <div class="mb-3">
                <label>Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           required minlength="6">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            {{-- Date of Birth --}}
            <div class="mb-3">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>

            {{-- Gender --}}
            <div class="mb-3">
                <label>Gender</label>
                <div class="d-flex gap-3 mt-1">
                    <label>
                        <input type="radio" name="gender" value="male"> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female"> Female
                    </label>
                    <label>
                        <input type="radio" name="gender" value="other"> Other
                    </label>
                </div>
            </div>

            {{-- Role Group --}}
            <div class="mb-3">
                <label>Role Group <span class="text-danger">*</span></label>
                <select name="role_group_id" class="form-control" required>
                    <option value="">Select Role Group</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Create Sub Admin</button>
        </form>
    </div>
</div>

{{-- Password Toggle Script --}}
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
