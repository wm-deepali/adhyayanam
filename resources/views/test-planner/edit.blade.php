@extends('layouts.app')

@section('title')
    Test Planner || Edit
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Edit</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Edit Test Planner here.</h6>
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
                <form id="test-form" method="POST" action="{{ route('test.planner.update', $testPlanner->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $testPlanner->title }}"
                            placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $testPlanner->start_date }}"
                            placeholder="Start Date" required>
                        @if ($errors->has('start_date'))
                            <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" placeholder="Short Description"
                            required>{{ $testPlanner->short_description }}</textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Description</label>
                        <textarea id="editor" name="detail_content"
                            style="height: 300px;">{{ $testPlanner->detail_content }}</textarea>
                        @if ($errors->has('detail_content'))
                            <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                        @endif
                    </div>

                    <!-- PDF -->
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Upload PDF</label>
                        <input type="file" class="form-control" name="pdf" accept="application/pdf">
                        @if ($errors->has('pdf'))
                            <span class="text-danger text-left">{{ $errors->first('pdf') }}</span>
                        @endif
                        @if ($testPlanner->pdf)
                            <a href="{{ asset('storage/' . $testPlanner->pdf) }}" target="_blank"
                                download="{{$testPlanner->title}}">View current PDF</a>
                        @endif
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>

                        <input type="file" class="form-control" id="image" name="image" accept="image/*">

                        <small class="text-muted">
                            Recommended size: 800x600px
                        </small>

                        {{-- Preview --}}
                        <div class="mt-3">

                            <img id="image-preview" src="{{ $testPlanner->image
        ? asset('storage/' . $testPlanner->image)
        : '' }}" alt="Preview" style="
                    {{ $testPlanner->image ? '' : 'display:none;' }}
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
                            <option value="1" {{ $testPlanner->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $testPlanner->status == 0 ? 'selected' : '' }}>Inactive</option>
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