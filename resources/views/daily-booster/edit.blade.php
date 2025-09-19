@extends('layouts.app')

@section('title')
Daily Booster || Edit
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Edit Daily Booster here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form id="daily-form" method="POST" action="{{ route('daily.boost.update', $dailyBooster->id) }}" enctype="multipart/form-data">
                @csrf
            
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $dailyBooster->title }}" placeholder="Title" required>
                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $dailyBooster->start_date }}" placeholder="Start Date" required>
                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
            
                <!-- YouTube URL -->
                <div class="mb-3">
                    <label for="youtube_url" class="form-label">YouTube URL</label>
                    <input type="text" class="form-control" name="youtube_url" value="{{ $dailyBooster->youtube_url }}" placeholder="YouTube URL">
                    @if ($errors->has('youtube_url'))
                        <span class="text-danger text-left">{{ $errors->first('youtube_url') }}</span>
                    @endif
                </div>
            
                <!-- Short Description -->
                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_description" placeholder="Short Description" required>{{ $dailyBooster->short_description }}</textarea>
                    @if ($errors->has('short_description'))
                        <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                    @endif
                </div>
            
                <!-- Detail Content -->
                <div class="mb-3">
                    <label for="detail_content" class="form-label">Description</label>
                    <textarea id="editor" name="detail_content" style="height: 300px;">{!! $dailyBooster->detail_content !!}</textarea>
                    @if ($errors->has('detail_content'))
                        <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                    @endif
                </div>
            
                <!-- Thumbnail -->
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control" name="thumbnail" accept="image/*" value="{{ $dailyBooster->thumbnail}}">
                    @if ($dailyBooster->thumbnail)
                        <img src="{{ asset('storage/' . $dailyBooster->thumbnail) }}" alt="Thumbnail" width="100">
                    @endif
                    @if ($errors->has('thumbnail'))
                        <span class="text-danger text-left">{{ $errors->first('thumbnail') }}</span>
                    @endif
                </div>
            
                <!-- Image Alt Tag -->
                <div class="mb-3">
                    <label for="image_alt_tag" class="form-label">Image Alt Tag</label>
                    <input type="text" class="form-control" name="image_alt_tag" value="{{ $dailyBooster->image_alt_tag }}" placeholder="Image Alt Tag">
                    @if ($errors->has('image_alt_tag'))
                        <span class="text-danger text-left">{{ $errors->first('image_alt_tag') }}</span>
                    @endif
                </div>
            
                <!-- Meta Title -->
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ $dailyBooster->meta_title }}" placeholder="Meta Title">
                    @if ($errors->has('meta_title'))
                        <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                    @endif
                </div>
            
                <!-- Meta Keyword -->
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                    <input type="text" class="form-control" name="meta_keyword" value="{{ $dailyBooster->meta_keyword }}" placeholder="Meta Keyword">
                    @if ($errors->has('meta_keyword'))
                        <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                    @endif
                </div>
            
                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{ $dailyBooster->meta_description }}" placeholder="Meta Description">
                    @if ($errors->has('meta_description'))
                        <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                    @endif
                </div>
            
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('daily.boost.index') }}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
         CKEDITOR.replace('editor');
    });
</script>
@endsection
