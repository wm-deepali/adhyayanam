@extends('layouts.app')

@section('title')
    Test Planner || Create
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Create</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Create Test Planner here.</h6>
                </div>

                <div>
                    <a href="{{ route('test.planner.index') }}" class="btn btn-secondary">
                        ← Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form id="test-form" method="POST" action="{{ route('test.planner.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" placeholder="Start Date" required>
                        @if ($errors->has('start_date'))
                            <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" placeholder="Short Description"
                            required></textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Description</label>
                        <textarea id="editor" name="detail_content" style="height: 300px;"></textarea>
                        @if ($errors->has('detail_content'))
                            <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                        @endif
                    </div>

                    <!-- PDF -->
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Upload PDF</label>
                        <input type="file" class="form-control" name="pdf" accept="application/pdf" required>
                        @if ($errors->has('pdf'))
                            <span class="text-danger text-left">{{ $errors->first('pdf') }}</span>
                        @endif
                    </div>

                    <!-- Thumbnail Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>

                        <input type="file" class="form-control" id="image" name="image" accept="image/*">

                        <small class="text-muted">
                            Recommended size: 800x600px
                        </small>

                        {{-- Preview --}}
                        <div class="mt-3">
                            <img id="image-preview" src="" alt="Preview" style="
                    display:none;
                    width:220px;
                    height:140px;
                    object-fit:cover;
                    border-radius:12px;
                    border:1px solid #ddd;
                    padding:4px;
                    background:#fff;
                ">
                        </div>

                        @if ($errors->has('image'))
                            <span class="text-danger text-left">
                                {{ $errors->first('image') }}
                            </span>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inctive</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor', {
                 extraPlugins: 'mathjax',
                mathJaxLib: 'https://cdn.jsdelivr.net/npm/mathjax@2/MathJax.js?config=TeX-AMS_HTML',
                removePlugins: 'easyimage,cloudservices',
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
    <script>
    document.getElementById('image').addEventListener('change', function (e) {

        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');

        if (file) {

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';

        } else {

            preview.style.display = 'none';
        }
    });
</script>
@endsection