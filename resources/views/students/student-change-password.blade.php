@extends('layouts.app')

@section('title')
Change Password
@endsection

@section('content')
<style>
    button.multiselect{
        width: 300px !important;
        border: 1px solid var(--cui-form-select-border-color, #b1b7c1) !important; 
    }
    .dropdown-menu.show
    {
        width: 300px !important;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Change Password</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Change Password here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('students.update-password', $id) }}" enctype="multipart/form-data">
                @csrf
                

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Confirm Password" required onkeyup="validate_password()">
                    @if ($errors->has('confirm_password'))
                        <span class="text-danger text-left">{{ $errors->first('confirm_password') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                <span id="wrong_pass_alert"></span>
                </div>
                
            
                <button type="submit" class="btn btn-primary" id="create">Update Password</button>
                <a href="{{route('students.student-profile-detail', $id)}}" class="btn">Back</a>
            </form>
            
        </div>
    </div>
</div>

@endsection
@push('after-scripts')
<script>
    function validate_password() {
 
 let pass = document.getElementById('password').value;
 let confirm_pass = document.getElementById('confirm_password').value;
 if (pass != confirm_pass) {
     document.getElementById('wrong_pass_alert').style.color = 'red';
     document.getElementById('wrong_pass_alert').innerHTML
         = '☒ Use same password';
     document.getElementById('create').disabled = true;
     document.getElementById('create').style.opacity = (0.4);
 } else {
     document.getElementById('wrong_pass_alert').style.color = 'green';
     document.getElementById('wrong_pass_alert').innerHTML =
         '🗹 Password Matched';
     document.getElementById('create').disabled = false;
     document.getElementById('create').style.opacity = (1);
 }
}

</script>
@endpush
