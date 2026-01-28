@extends('layouts.app')

@section('title')
    Edit Blog & Article
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h5 class="card-title">Add Blog & Article</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Add your blog & article section here.</h6>
                    </div>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <form method="POST" action="{{ route('blog.store') }}" id="blog-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="heading" class="form-label">Heading</label>
                            <input type="text" class="form-control" name="heading" placeholder="Heading" required>
                            @if ($errors->has('heading'))
                                <span class="text-danger text-left">{{ $errors->first('heading') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <input type="text" class="form-control" name="short_description"
                                placeholder="Short Description">
                            @if ($errors->has('short_description'))
                                <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="editor" name="description" style="height: 200px;"></textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" name="type" placeholder="Type">
                            @if ($errors->has('type'))
                                <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                            @if ($errors->has('image'))
                                <span class="text-danger text-left">{{ $errors->first('image') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" accept="image/*">
                            @if ($errors->has('thumbnail'))
                                <span class="text-danger text-left">{{ $errors->first('thumbnail') }}</span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Save Blog</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
@endsection