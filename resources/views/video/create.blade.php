@extends('layouts.app')

@section('title')
    Manage Video
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    Create live class or video learning content here.
                </h6>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                @include('video.form', ['video' => new App\Models\Video()])
            </div>
        </div>
    </div>

@endsection