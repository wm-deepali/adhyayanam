@extends('layouts.app')

@section('title')
    Manage Video
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Create</h5>
                    <small class="text-muted">Create live class or video learning content here.</small>
                </div>
                <a href="{{ route('video.index') }}" class="btn btn-secondary">← Back</a>
            </div>
            <div class="card-body">

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                @include('video.form', ['video' => new App\Models\Video()])
            </div>
        </div>
    </div>

@endsection