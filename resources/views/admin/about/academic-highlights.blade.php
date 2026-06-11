@extends('layouts.app')

@section('title')
    Academic Highlights
@endsection

@section('content')

    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Academic Highlights</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage Academic Highlights Section.
                        </h6>
                    </div>

                    <a href="{{ route('about.index') }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form method="POST" enctype="multipart/form-data" action="{{ route('about.academic-highlights.store') }}">

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

                                <input type="text" class="form-control" name="sub_title"
                                    value="{{ old('sub_title', $section->sub_title ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Heading
                                </label>

                                <input type="text" class="form-control" name="heading"
                                    value="{{ old('heading', $section->heading ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Short Description
                                </label>

                                <textarea class="form-control" rows="4"
                                    name="short_description">{{ old('short_description', $section->description ?? '') }}</textarea>
                            </div>

                           <div class="mb-3">
    <label class="form-label">
        Right Side Image 1
    </label>

    <input type="file"
           class="form-control"
           name="image_1">

    @if(!empty($section->extra_data['image_1']))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$section->extra_data['image_1']) }}"
                 class="img-thumbnail"
                 style="max-width:200px;">
        </div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label">
        Right Side Image 2
    </label>

    <input type="file"
           class="form-control"
           name="image_2">

    @if(!empty($section->extra_data['image_2']))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$section->extra_data['image_2']) }}"
                 class="img-thumbnail"
                 style="max-width:200px;">
        </div>
    @endif
</div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Highlight Cards</span>

                            <button type="button" class="btn btn-success btn-sm" id="add-highlight">
                                Add Card
                            </button>
                        </div>

                        <div class="card-body">

                            <div id="highlight-wrapper">

                                @forelse($highlights as $highlight)

                                    <div class="highlight-card border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>Icon Class</label>

                                                <input type="text" class="form-control" name="card_icon[]"
                                                    value="{{ $highlight->icon }}" placeholder="fa-solid fa-landmark">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Heading</label>

                                                <input type="text" class="form-control" name="card_heading[]"
                                                    value="{{ $highlight->heading }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Description</label>

                                                <textarea class="form-control" rows="2"
                                                    name="card_description[]">{{ $highlight->short_description }}</textarea>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-highlight">
                                                    X
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="highlight-card border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>Icon Class</label>

                                                <input type="text" class="form-control" name="card_icon[]"
                                                    placeholder="fa-solid fa-landmark">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Heading</label>

                                                <input type="text" class="form-control" name="card_heading[]">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Description</label>

                                                <textarea class="form-control" rows="2" name="card_description[]"></textarea>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-highlight">
                                                    X
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @endforelse

                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        Save Changes
                    </button>

                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#add-highlight').click(function () {

                let totalCards = $('.highlight-card').length;

                if (totalCards >= 4) {
                    alert('Maximum 4 cards allowed.');
                    return;
                }

                let html = `
            <div class="highlight-card border rounded p-3 mb-3">

                <div class="row">

                    <div class="col-md-3">
                        <label>Icon Class</label>

                        <input type="text"
                               class="form-control"
                               name="card_icon[]"
                               placeholder="fa-solid fa-landmark">
                    </div>

                    <div class="col-md-4">
                        <label>Heading</label>

                        <input type="text"
                               class="form-control"
                               name="card_heading[]">
                    </div>

                    <div class="col-md-4">
                        <label>Description</label>

                        <textarea class="form-control"
                                  rows="2"
                                  name="card_description[]"></textarea>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button"
                                class="btn btn-danger remove-highlight">
                            X
                        </button>
                    </div>

                </div>

            </div>
            `;

                $('#highlight-wrapper').append(html);

            });

            $(document).on('click', '.remove-highlight', function () {

                $(this)
                    .closest('.highlight-card')
                    .remove();

            });

        });

    </script>

@endsection