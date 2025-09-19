@extends('layouts.app')

@section('title')
Edit|Our Team Management
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Edit your our team section here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('cm.our.team.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="name" 
                           placeholder="Name" value="{{$team->name ?? ""}}" required>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <input type="text" style="display:none;" name="id" value="{{$team->id}}">
                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="designation" 
                           placeholder="Designation" value="{{$team->designation ?? ""}}" required>
                    @if ($errors->has('designation'))
                        <span class="text-danger text-left">{{ $errors->first('designation') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="experience" class="form-label">Experience</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="experience"
                           placeholder="Experience" value="{{$team->experience ?? ""}}">
                    @if ($errors->has('experience'))
                        <span class="text-danger text-left">{{ $errors->first('experience') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="education" class="form-label">Education</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="education" 
                           placeholder="Education" value="{{$team->education ?? ""}}">
                    @if ($errors->has('education'))
                        <span class="text-danger text-left">{{ $errors->first('education') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Upload Image</label>
                    <input type="file" 
                        class="form-control" 
                        name="profile_image" 
                        id="profile_image" accept="image/*" value="{{$team->profile_image ?? ""}}">
                    <img src="asset($team->profile_image)" alt="" style="max-width:60px">
                    @if ($errors->has('profile_image'))
                        <span class="text-danger text-left">{{ $errors->first('profile_image') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection