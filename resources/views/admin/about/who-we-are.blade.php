@extends('layouts.app')

@section('title')
    Who We Are
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Who We Are</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage Who We Are section.
                    </h6>
                </div>

                <a href="{{ route('about.index') }}"
                   class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form method="POST"
                  action="{{ route('about.who-we-are.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Sub Title
                    </label>

                    <input type="text"
                           class="form-control"
                           name="sub_title"
                           value="{{ old('sub_title', $section->sub_title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Heading
                    </label>

                    <input type="text"
                           class="form-control"
                           name="heading"
                           value="{{ old('heading', $section->heading ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Description
                    </label>

                    <textarea id="editor"
                              name="description"
                              class="form-control"
                              rows="8">{!! old('description', $section->description ?? '') !!}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Image
                    </label>

                    <input type="file"
                           class="form-control"
                           name="image">
                </div>

                @if(!empty($section->image))
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$section->image) }}"
                             class="img-thumbnail"
                             style="max-width:200px;">
                    </div>
                @endif

                <button type="submit"
                        class="btn btn-primary">
                    Save Changes
                </button>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>

@endsection