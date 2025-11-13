@extends('layouts.app')

@section('title')
Edit Blog & Article
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Blog & Article</h5>
            <h6 class="card-subtitle mb-2 text-muted">Update your blog & article section here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <form method="POST" action="{{ route('blog.update', $blog->id) }}" id="blog-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="heading" class="form-label">Heading</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="heading" 
                            placeholder="Heading" 
                            value="{{ old('heading', $blog->heading) }}" 
                            required>
                        @if ($errors->has('heading'))
                            <span class="text-danger">{{ $errors->first('heading') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="short_description" 
                            placeholder="Short Description"
                            value="{{ old('short_description', $blog->short_description) }}">
                        @if ($errors->has('short_description'))
                            <span class="text-danger">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="editor" name="description" style="height: 200px;">{{ old('description', $blog->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input
                            type="text" 
                            class="form-control" 
                            name="type" 
                            placeholder="Type"
                            value="{{ old('type', $blog->type) }}">
                        @if ($errors->has('type'))
                            <span class="text-danger">{{ $errors->first('type') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input 
                            type="file" 
                            class="form-control" 
                            name="image" 
                            accept="image/*">
                        @if ($blog->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="Image" width="100">
                            </div>
                        @endif
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input 
                            type="file" 
                            class="form-control" 
                            name="thumbnail" 
                            accept="image/*">
                        @if ($blog->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail" width="100">
                            </div>
                        @endif
                        @if ($errors->has('thumbnail'))
                            <span class="text-danger">{{ $errors->first('thumbnail') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update Blog</button>
                    <a href="{{ route('cm.blog.articles') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('editor');
    });
</script>
@endsection
