@extends('layouts.app')

@section('title')
    Edit | Syllabus
@endsection

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Edit Syllabus</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Update syllabus details below.</h6>
                    </div>
                </div>

                <div class="mt-2">@include('layouts.includes.messages')</div>

                <form method="POST" action="{{ route('syllabus.update', $syllabus->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Commission --}}
                    <div class="mb-3">
                        <label for="commission_id" class="form-label">Examination Commission</label>
                        <select class="form-select" name="commission_id" id="commission_id" required>
                            <option value="" disabled>None</option>
                            @foreach($commissions as $commission)
                                <option value="{{ $commission->id }}" {{ $syllabus->commission_id == $commission->id ? 'selected' : '' }}>
                                    {{ $commission->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('commission_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            <option value="" disabled>None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $syllabus->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Subcategory --}}
                    <div class="mb-3 sub-cat {{ empty($subcategories) ? 'hidecls' : '' }}">
                        <label for="sub_category_id" class="form-label">Sub Category</label>
                        <select class="form-select" name="sub_category_id" id="sub_category_id">
                            <option value="" disabled>None</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $syllabus->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Subject --}}
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" name="subject_id" id="subject_id">
                            <option value="" disabled>None</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $syllabus->subject_id == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $syllabus->title }}"
                            required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- PDF --}}
                    <div class="mb-3">
                        <label for="pdf" class="form-label">PDF</label>
                        <input type="file" class="form-control" name="pdf" accept="application/pdf">
                        @if ($syllabus->pdf)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $syllabus->pdf) }}" target="_blank">
                                    <img src="{{ asset('img/pdficon.png') }}" height="60px" alt="PDF">
                                </a>
                            </div>
                        @endif
                        @error('pdf') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="1" {{ $syllabus->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $syllabus->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Detail Content --}}
                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Detail Content</label>
                        <textarea name="detail_content" id="detail_content" class="form-control"
                            rows="5">{{ old('detail_content', $syllabus->detail_content) }}</textarea>
                        @error('detail_content') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('syllabus.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
             CKEDITOR.replace('detail_content', {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
    filebrowserUploadMethod: 'form'
});
           
        });

        $(document).ready(function () {
            // Fetch categories by commission
            $('#commission_id').change(function () {
                let commissionId = $(this).val();
                if (!commissionId) return;
                $.get(`{{ url('fetch-exam-category-by-commission') }}/${commissionId}`, function (result) {
                    if (result.success) $('#category_id').html(result.html);
                });
            });

            // Fetch subcategories by category
            $('#category_id').change(function () {
                let categoryId = $(this).val();
                if (!categoryId) return;
                $.get(`{{ url('fetch-sub-category-by-exam-category') }}/${categoryId}`, function (result) {
                    if (result.success) {
                        if (result.html) {
                            $('#sub_category_id').html(result.html);
                            $('.sub-cat').removeClass('hidecls');
                        } else {
                            $('.sub-cat').addClass('hidecls');
                        }
                    }
                });
            });

            // Fetch subjects by subcategory
            $('#sub_category_id').change(function () {
                let subCatId = $(this).val();
                if (!subCatId) return;
                $.get(`{{ url('fetch-subject-by-subcategory') }}/${subCatId}`, function (response) {
                    if (response.success) $('#subject_id').html(response.html);
                });
            });
        });
    </script>
@endpush