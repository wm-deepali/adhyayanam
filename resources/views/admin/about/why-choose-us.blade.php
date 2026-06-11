@extends('layouts.app')

@section('title')
    Why Choose Us
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Why Choose Us</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage Why Choose Us Section.
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
                  action="{{ route('about.why-choose-us.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="card mt-3">
                    <div class="card-header">
                        Section Content
                    </div>

                    <div class="card-body">

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
        Quote Content
    </label>

    <textarea class="form-control"
              rows="4"
              name="quote">{{ old('quote', $section->extra_data['quote'] ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">
        Image
    </label>

    <input type="file"
           class="form-control"
           name="image">

    @if(!empty($section->extra_data['image']))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$section->extra_data['image']) }}"
                 class="img-thumbnail"
                 style="max-width:200px;">
        </div>
    @endif
</div>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Key Strengths</span>

                        <button type="button"
                                class="btn btn-success btn-sm"
                                id="add-strength">
                            Add Strength
                        </button>
                    </div>

                    <div class="card-body">

                        <div id="strength-wrapper">

                            @forelse($strengths as $strength)

                                <div class="strength-row border rounded p-3 mb-3">

                                    <div class="row">

                                        <div class="col-md-11">

                                            <label>
                                                Strength Title
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="strength_title[]"
                                                   value="{{ $strength->title }}">

                                        </div>

                                        <div class="col-md-1 d-flex align-items-end">

                                            <button type="button"
                                                    class="btn btn-danger remove-strength">
                                                X
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="strength-row border rounded p-3 mb-3">

                                    <div class="row">

                                        <div class="col-md-11">

                                            <label>
                                                Strength Title
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="strength_title[]">

                                        </div>

                                        <div class="col-md-1 d-flex align-items-end">

                                            <button type="button"
                                                    class="btn btn-danger remove-strength">
                                                X
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endforelse

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>

<script>

$(document).ready(function(){

    $('#add-strength').click(function(){

        let html = `
        <div class="strength-row border rounded p-3 mb-3">

            <div class="row">

                <div class="col-md-11">

                    <label>
                        Strength Title
                    </label>

                    <input type="text"
                           class="form-control"
                           name="strength_title[]">

                </div>

                <div class="col-md-1 d-flex align-items-end">

                    <button type="button"
                            class="btn btn-danger remove-strength">
                        X
                    </button>

                </div>

            </div>

        </div>
        `;

        $('#strength-wrapper').append(html);

    });

    $(document).on('click', '.remove-strength', function(){

        if($('.strength-row').length > 1){
            $(this).closest('.strength-row').remove();
        }

    });

});

</script>

@endsection