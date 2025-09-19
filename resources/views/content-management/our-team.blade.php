@extends('layouts.app')

@section('title')
Our Team Management
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Our Team</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage your our team section here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ url('content-management/our-team/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="name" 
                           placeholder="Name" required>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input 
                           type="text" 
                           class="form-control" 
                           name="designation" 
                           placeholder="Designation" required>
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
                           placeholder="Experience">
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
                           placeholder="Education">
                    @if ($errors->has('education'))
                        <span class="text-danger text-left">{{ $errors->first('education') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Upload Image</label>
                    <input type="file" 
                        class="form-control" 
                        name="profile_image" 
                        id="profile_image" accept="image/*">
                    
                    @if ($errors->has('profile_image'))
                        <span class="text-danger text-left">{{ $errors->first('profile_image') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col" width="1%">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Experience</th>
                        <th scope="col">Education</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><img src="{{ asset('storage/' . $team->profile_image) }}" alt="Uploaded Image" class="img-thumbnail" style="max-width: 40px; max-height: 40px;border-radius:30px;"></td>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->designation ?? "--" }}</td>
                        <td>{{ $team->experience ?? "--" }}</td>
                        <td>{{ $team->education ?? "--" }}</td>
                        <td>
                            <a href="{{route('cm.our.team.edit',$team->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('cm.our.team.delete', $team->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection