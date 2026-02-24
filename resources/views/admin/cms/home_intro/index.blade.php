@extends('layouts.app')

@section('title')
    Manage Introduction
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Introduction</h5>
                        <h6 class="card-subtitle text-muted">Manage homepage introduction section.</h6>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <form method="POST" action="{{ route('cm.home.intro.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Heading -->
                        <div class="mb-3">
                            <label class="form-label">Heading</label>
                            <input type="text" name="heading" class="form-control" value="{{ $intro->heading ?? '' }}"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="editor" name="description" class="form-control" style="height:300px;">
                                {!! $intro->description ?? '' !!}
                            </textarea>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        @if(!empty($intro->image))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $intro->image) }}" class="img-thumbnail"
                                    style="max-width:200px;">
                            </div>
                        @endif

                        <hr>

                        <h6>Important Highlights</h6>

                        <div id="highlights-wrapper">

                            @if(isset($intro->highlights))
                                @foreach($intro->highlights as $h)
                                    <div class="highlight-item mb-2 d-flex gap-2">

                                        <input type="hidden" name="highlights[{{ $loop->index }}][id]" value="{{ $h->id }}">

                                        <input type="text" name="highlights[{{ $loop->index }}][text]" class="form-control"
                                            value="{{ $h->text }}" placeholder="Highlight text">

                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeHighlight(this)">
                                            ✕
                                        </button>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addHighlight()">
                            + Add Highlight
                        </button>

                        <hr>

                        @if(\App\Helpers\Helper::canAccess('manage_home_intro'))
                            <button class="btn btn-primary">Save</button>
                        @endif

                        @if(isset($intro->updated_at))
                            <div class="text-muted mt-2">
                                <small>
                                    Last updated
                                    @if($intro->updater)
                                        by <strong>{{ $intro->updater->name }}</strong>
                                    @endif
                                    on {{ $intro->updated_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('editor');

        function addHighlight() {
            let wrapper = document.getElementById('highlights-wrapper');
            let index = wrapper.children.length;

            wrapper.insertAdjacentHTML('beforeend', `
            <div class="highlight-item mb-2 d-flex gap-2">

                <input type="hidden" name="highlights[${index}][id]" value="">

                <input type="text"
                       name="highlights[${index}][text]"
                       class="form-control"
                       placeholder="Highlight text">

                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="removeHighlight(this)">
                    ✕
                </button>
            </div>
        `);
        }

        function removeHighlight(btn) {
            btn.closest('.highlight-item').remove();
        }
    </script>
@endsection