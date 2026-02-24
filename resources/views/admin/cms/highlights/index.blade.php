@extends('layouts.app')
@section('title', 'Institute Highlights')

@section('content')
<div class="card">
<div class="card-body">

    <h5 class="mb-3">Institute Highlights</h5>

    @include('layouts.includes.messages')

    <form method="POST" action="{{ route('cm.institute.highlights') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <!-- Image -->
            <div class="col-md-4 mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">

                @if(!empty($highlight->image))
                    <img src="{{ asset('storage/'.$highlight->image) }}"
                         width="120"
                         class="mt-2 rounded">
                @endif
            </div>

            <!-- Sub Title -->
            <div class="col-md-4 mb-3">
                <label>Sub Title</label>
                <input type="text"
                       name="sub_title"
                       value="{{ $highlight->sub_title ?? '' }}"
                       class="form-control">
            </div>

            <!-- Main Heading -->
            <div class="col-md-4 mb-3">
                <label>Main Heading</label>
                <input type="text"
                       name="main_heading"
                       value="{{ $highlight->main_heading ?? '' }}"
                       class="form-control">
            </div>

            <!-- Short Description -->
            <div class="col-md-12 mb-3">
                <label>Short Description</label>
                <textarea id="shortDescEditor"
                          name="short_description"
                          class="form-control">{!! $highlight->short_description ?? '' !!}</textarea>
            </div>

            <!-- Sub Sub Title -->
            <div class="col-md-4 mb-3">
                <label>Sub Sub Title</label>
                <input type="text"
                       name="sub_sub_title"
                       value="{{ $highlight->sub_sub_title ?? '' }}"
                       class="form-control">
            </div>

        </div>

        <hr>

        <h6>Highlight Points</h6>

        <div id="pointsWrapper">

            @if(isset($highlight->points))
                @foreach($highlight->points as $point)
                <div class="row mb-2 point-row">

                    <!-- Icon Upload -->
                    <div class="col-md-3">
                        <input type="file"
                               name="points[{{ $loop->index }}][icon_image]"
                               class="form-control icon-input">

                        @if(!empty($point->icon_image))
                            <img src="{{ asset('storage/'.$point->icon_image) }}"
                                 width="40"
                                 class="mt-1 preview">
                        @else
                            <img width="40" class="mt-1 preview" style="display:none;">
                        @endif
                    </div>

                    <!-- Comment -->
                    <div class="col-md-7">
                        <input type="text"
                               name="points[{{ $loop->index }}][comment]"
                               value="{{ $point->comment }}"
                               class="form-control"
                               placeholder="Comment">
                    </div>

                    <!-- Remove -->
                    <div class="col-md-2">
                        <button type="button"
                                class="btn btn-danger"
                                onclick="removePoint(this)">✕</button>
                    </div>

                </div>
                @endforeach
            @endif

        </div>

        <button type="button"
                class="btn btn-outline-primary mt-2"
                onclick="addPoint()">
            + Add Point
        </button>

        <br><br>

        <button class="btn btn-primary">Save Highlights</button>

    </form>

</div>
</div>
@endsection


@push('after-scripts')

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    // CKEditor
    CKEDITOR.replace('shortDescEditor', {
        height: 150,
        toolbar: [
            ['Bold','Italic','BulletedList','Link','Unlink']
        ]
    });

    // add new point
    window.addPoint = function() {
        let index = document.querySelectorAll('.point-row').length;

        let html = `
        <div class="row mb-2 point-row">

            <div class="col-md-3">
                <input type="file"
                       name="points[${index}][icon_image]"
                       class="form-control icon-input">
                <img class="preview mt-1"
                     width="40"
                     style="display:none;">
            </div>

            <div class="col-md-7">
                <input type="text"
                       name="points[${index}][comment]"
                       class="form-control"
                       placeholder="Comment">
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger"
                        onclick="removePoint(this)">✕</button>
            </div>
        </div>`;

        document.getElementById('pointsWrapper')
            .insertAdjacentHTML('beforeend', html);
    }

    // remove point
    window.removePoint = function(btn) {
        btn.closest('.point-row').remove();
    }

    // icon preview
    document.addEventListener('change', function(e){
        if(e.target.classList.contains('icon-input')){
            const preview = e.target.nextElementSibling;
            preview.src = URL.createObjectURL(e.target.files[0]);
            preview.style.display = 'block';
        }
    });

});
</script>

@endpush