@extends('layouts.app')

@section('title')
    Join Us
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Join Us</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage Join Us Section.
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
                  action="{{ route('about.join-us.store') }}"
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

                        <hr>

                        <h5 class="mb-3">
                            Button 1
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">
                                Button 1 Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="button_1_name"
                                   value="{{ old('button_1_name', $section->extra_data['button_1_name'] ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Button 1 Link
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="button_1_link"
                                   value="{{ old('button_1_link', $section->extra_data['button_1_link'] ?? '') }}">
                        </div>

                        <hr>

                        <h5 class="mb-3">
                            Button 2
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">
                                Button 2 Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="button_2_name"
                                   value="{{ old('button_2_name', $section->extra_data['button_2_name'] ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Button 2 Link
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="button_2_link"
                                   value="{{ old('button_2_link', $section->extra_data['button_2_link'] ?? '') }}">
                        </div>

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