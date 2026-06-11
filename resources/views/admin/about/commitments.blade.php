@extends('layouts.app')

@section('title')
    Our Commitments
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Our Commitments</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage Our Commitments Section.
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
                  action="{{ route('about.commitments.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="card mt-3">
                    <div class="card-body">

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
                                     style="max-width:250px;">
                            </div>
                        @endif

                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary mt-3">
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