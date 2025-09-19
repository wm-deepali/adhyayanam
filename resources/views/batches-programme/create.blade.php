@extends('layouts.app')

@section('title')
Create | Batches and Online Programme
@endsection
@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Create</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Add Batches and Online Programme here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('batches-programme.store') }}" id="batch-form" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date*</label>
                            <input type="date" class="form-control" name="start_date" placeholder="Start Date" required>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="batch_heading" class="form-label">Heading*</label>
                        <input type="text" class="form-control" name="batch_heading" placeholder="Heading" required>
                        @error('batch_heading')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" placeholder="Duration" required>
                            @error('duration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mrp" class="form-label">MRP</label>
                            <input type="number" class="form-control" name="mrp" placeholder="MRP" required>
                            @error('mrp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" name="discount" placeholder="Discount" required>
                            @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="offered_price" class="form-label">Offered Price</label>
                            <input type="number" class="form-control" name="offered_price" placeholder="Offered Price" required>
                            @error('offered_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <input type="text" class="form-control" name="short_description" placeholder="Short Description" required>
                            @error('short_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="thumbnail_image" class="form-label">Upload Thumbnail</label>
                            <input type="file" 
                                class="form-control" 
                                name="thumbnail_image" 
                                id="thumbnail_image" accept="image/*">
                            
                            @if ($errors->has('thumbnail_image'))
                                <span class="text-danger text-left">{{ $errors->first('thumbnail_image') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="course_overview" class="form-label">Batch Overview*</label>
                    <div id="course_overview" style="height: 200px;"></div>
                    @error('batch_overview')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="detail_content" class="form-label">Batch Detail*</label>
                    <div id="detail_content" style="height: 200px;"></div>
                    @error('detail_content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Upload Banner</label>
                            <input type="file" 
                                class="form-control" 
                                name="banner_image" 
                                id="banner_image" accept="image/*">
                            
                            @if ($errors->has('banner_image'))
                                <span class="text-danger text-left">{{ $errors->first('banner_image') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">Youtube Video Url</label>
                            <input type="text" class="form-control" name="youtube_url" placeholder="Youtube Video Url" required>
                            @error('youtube_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" required>
                            @error('meta_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_keyword" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keyword" placeholder="Tag, Tag" required>
                            @error('meta_keyword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <input type="text" class="form-control" name="meta_description" placeholder="Meta Description" required>
                            @error('meta_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image_alt_tag" class="form-label">Alt Tag</label>
                            <input type="text" class="form-control" name="image_alt_tag" placeholder="Tag" required>
                            @error('image_alt_tag')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('batches-programme.index') }}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#course_overview', {
        modules: {
            toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block'],
            ],
        },
        placeholder: 'Design Overview of the course',
        theme: 'snow', // or 'bubble'
        });

        var quill2 = new Quill('#detail_content', {
        modules: {
            toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block'],
            ],
        },
        placeholder: 'Write and design details of the course',
        theme: 'snow', // or 'bubble'
        });

        const form = document.getElementById('batch-form');
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent default form submission

            // Get Quill content as HTML
            const overview = quill.root.innerHTML;
            const detail = quill2.root.innerHTML;
            
            // Create a hidden input to hold the Quill content
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'batch_overview';
            hiddenInput.value = overview;
            form.appendChild(hiddenInput);

            const hiddenInput2 = document.createElement('input');
            hiddenInput2.type = 'hidden';
            hiddenInput2.name = 'detail_content';
            hiddenInput2.value = detail;

            // Append the hidden input to the form
            
            form.appendChild(hiddenInput2);

            // Submit the form
            form.submit();
        });
    });
</script>
@endsection