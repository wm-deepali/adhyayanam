@extends('layouts.app')

@section('title', 'Student Dashboard Banner')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Student Dashboard Banner Settings</strong>
                    </div>
                    <div class="card-body">

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

                        <form action="{{ route('settings.dashboard-banner.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Heading Text</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $banner->title ?? 'Learn With Effectively With Us!') }}" required>
                                <small class="text-muted">This shows as the big heading on the student dashboard banner.</small>
                            </div>

                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Sub Text</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle"
                                    value="{{ old('subtitle', $banner->subtitle ?? 'Get 30% off every course on january.') }}">
                                <small class="text-muted">Shown below the heading.</small>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Banner Background Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp">
                                <small class="text-muted">Recommended: transparent PNG or SVG works best (shown on the right side of the banner).</small>

                                @if(!empty($banner->image))
                                    <div class="mt-15 mt-3">
                                        <p class="mb-1 text-muted">Current Image:</p>
                                        <img src="{{ asset('storage/' . $banner->image) }}" alt="Current Banner" style="max-height: 120px; border-radius: 8px;">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection