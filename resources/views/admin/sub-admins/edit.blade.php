@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Sub Admin</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('sub-admins.update', $user->id) }}" method="POST">
            @csrf
            @method('POST')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="first_name"
                           value="{{ old('first_name', $user->first_name) }}"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input type="text"
                           name="last_name"
                           value="{{ old('last_name', $user->last_name) }}"
                           class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       value="{{ $user->email }}"
                       class="form-control"
                       disabled>
            </div>

            <div class="mb-3">
                <label>Mobile <span class="text-danger">*</span></label>
                <input type="text"
                       name="mobile"
                       value="{{ old('mobile', $user->mobile) }}"
                       class="form-control"
                       required>
            </div>

            {{-- Date of Birth --}}
            <div class="mb-3">
                <label>Date of Birth</label>
                <input type="date"
                       name="date_of_birth"
                       value="{{ old('date_of_birth', $user->date_of_birth) }}"
                       class="form-control">
            </div>

            {{-- Gender --}}
            <div class="mb-3">
                <label>Gender</label>
                <div class="d-flex gap-3 mt-1">
                    <label>
                        <input type="radio" name="gender" value="male"
                            {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                        Male
                    </label>

                    <label>
                        <input type="radio" name="gender" value="female"
                            {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                        Female
                    </label>

                    <label>
                        <input type="radio" name="gender" value="other"
                            {{ old('gender', $user->gender) == 'other' ? 'checked' : '' }}>
                        Other
                    </label>
                </div>
            </div>

            {{-- Optional Password Update --}}
            <div class="mb-3">
                <label>New Password <small class="text-muted">(leave blank to keep unchanged)</small></label>
                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           minlength="6">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            {{-- Role Group --}}
            <div class="mb-3">
                <label>Role Group <span class="text-danger">*</span></label>
                <select name="role_group_id" class="form-control" required>
                    <option value="">Select Role Group</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}"
                            {{ $user->role_group_id == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button class="btn btn-primary">Update Sub Admin</button>
            </div>

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
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection
