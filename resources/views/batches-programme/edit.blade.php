@extends('layouts.app')

@section('title')
Edit | Batches and Online Programme
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Update Batches and Online Programme here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('batches-programme.update', $batch->id) }}" id="batch-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $batch->name) }}" required>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date*</label>
                            <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $batch->start_date) }}" required>
                            @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="batch_heading" class="form-label">Heading*</label>
                        <input type="text" class="form-control" name="batch_heading" value="{{ old('batch_heading', $batch->batch_heading) }}" required>
                        @error('batch_heading')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" value="{{ old('duration', $batch->duration) }}" required>
                            @error('duration')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mrp" class="form-label">MRP</label>
                            <input type="number" class="form-control" name="mrp" value="{{ old('mrp', $batch->mrp) }}" required>
                            @error('mrp')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" name="discount" value="{{ old('discount', $batch->discount) }}">
                            @error('discount')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="offered_price" class="form-label">Offered Price</label>
                            <input type="number" class="form-control" name="offered_price" value="{{ old('offered_price', $batch->offered_price) }}" required>
                            @error('offered_price')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <input type="text" class="form-control" name="short_description" value="{{ old('short_description', $batch->short_description) }}" required>
                    @error('short_description')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <!-- Thumbnail -->
                <div class="mb-3">
                    <label for="thumbnail_image" class="form-label">Upload Thumbnail</label>
                    <input type="file" class="form-control" name="thumbnail_image" accept="image/*">
                    @if($batch->thumbnail_image)
                        <img src="{{ asset('storage/'.$batch->thumbnail_image) }}" style="height: 50px; width: auto; margin-top:5px;" alt="">
                    @endif
                </div>

                <!-- Batch Overview -->
                <div class="mb-3">
                    <label for="course_overview" class="form-label">Batch Overview*</label>
                    <div id="course_overview" style="height: 200px;">{!! old('batch_overview', $batch->batch_overview) !!}</div>
                    @error('batch_overview')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <!-- Batch Detail -->
                <div class="mb-3">
                    <label for="detail_content" class="form-label">Batch Detail*</label>
                    <div id="detail_content" style="height: 200px;">{!! old('detail_content', $batch->detail_content) !!}</div>
                    @error('detail_content')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <!-- Banner -->
                <div class="mb-3">
                    <label for="banner_image" class="form-label">Upload Banner</label>
                    <input type="file" class="form-control" name="banner_image" accept="image/*">
                    @if($batch->banner_image)
                        <img src="{{ asset('storage/'.$batch->banner_image) }}" style="height: 50px; width: auto; margin-top:5px;" alt="">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="youtube_url" class="form-label">Youtube Video Url</label>
                    <input type="text" class="form-control" name="youtube_url" value="{{ old('youtube_url', $batch->youtube_url) }}">
                    @error('youtube_url')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $batch->meta_title) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_keyword" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keyword" value="{{ old('meta_keyword', $batch->meta_keyword) }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description', $batch->meta_description) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image_alt_tag" class="form-label">Alt Tag</label>
                            <input type="text" class="form-control" name="image_alt_tag" value="{{ old('image_alt_tag', $batch->image_alt_tag) }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('batches-programme.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var quillOverview = new Quill('#course_overview', {
        modules: { toolbar: [['bold','italic','underline'], ['image','code-block']] },
        theme: 'snow'
    });
    var quillDetail = new Quill('#detail_content', {
        modules: { toolbar: [['bold','italic','underline'], ['image','code-block']] },
        theme: 'snow'
    });

    const form = document.getElementById('batch-form');
    form.addEventListener('submit', (event) => {
        const overviewInput = document.createElement('input');
        overviewInput.type = 'hidden';
        overviewInput.name = 'batch_overview';
        overviewInput.value = quillOverview.root.innerHTML;
        form.appendChild(overviewInput);

        const detailInput = document.createElement('input');
        detailInput.type = 'hidden';
        detailInput.name = 'detail_content';
        detailInput.value = quillDetail.root.innerHTML;
        form.appendChild(detailInput);
    });
});
</script>
@endsection
