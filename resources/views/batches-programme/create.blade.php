@extends('layouts.app')

@section('title')
    Create | Batches and Online Programme
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Create</h5>
                        <h6 class="card-subtitle text-muted">
                            Add Batches and Online Programme here.
                        </h6>
                    </div>

                    <div>
                        <a href="{{ route('batches-programme.index') }}" class="btn btn-secondary">
                            ← Back
                        </a>
                    </div>
                </div>


                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form method="POST" action="{{ route('batches-programme.store') }}" id="batch-form"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- NAME + START DATE -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name*</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date*</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                        </div>
                    </div>

                    <!-- HEADING -->
                    <div class="mb-3">
                        <label class="form-label">Heading*</label>
                        <input type="text" class="form-control" name="batch_heading" required>
                    </div>

                    <!-- DURATION + MRP -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">MRP</label>
                                <input type="number" class="form-control" name="mrp" id="mrp" required>
                            </div>
                        </div>
                    </div>

                    <!-- DISCOUNT + OFFERED PRICE -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Offered Price</label>
                                <input type="number" class="form-control" name="offered_price" id="offered_price" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- SHORT DESC + THUMB -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <input type="text" class="form-control" name="short_description" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Upload Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail_image" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- OVERVIEW -->
                    <div class="mb-3">
                        <label class="form-label">Batch Overview*</label>
                        <textarea name="batch_overview" id="course_overview"></textarea>
                    </div>

                    <!-- DETAILS -->
                    <div class="mb-3">
                        <label class="form-label">Batch Detail*</label>
                        <textarea name="detail_content" id="detail_content"></textarea>
                    </div>

                    <!-- BANNER + YOUTUBE -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Upload Banner</label>
                                <input type="file" class="form-control" name="banner_image" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Youtube Video Url</label>
                                <input type="text" class="form-control" name="youtube_url" required>
                            </div>
                        </div>
                    </div>

                    <!-- META -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keyword" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <input type="text" class="form-control" name="meta_description" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alt Tag</label>
                                <input type="text" class="form-control" name="image_alt_tag" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>

                </form>
            </div>
        </div>
    </div>

    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            CKEDITOR.replace('course_overview', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('detail_content', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            // AUTO PRICE CALCULATION
            const mrp = document.getElementById('mrp');
            const discount = document.getElementById('discount');
            const offered = document.getElementById('offered_price');

            function calculatePrice() {
                offered.value = (parseFloat(mrp.value) || 0) - (parseFloat(discount.value) || 0);
            }

            mrp.addEventListener('input', calculatePrice);
            discount.addEventListener('input', calculatePrice);

            // CKEditor Sync
            document.getElementById('batch-form').addEventListener('submit', function () {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        });
    </script>
@endsection