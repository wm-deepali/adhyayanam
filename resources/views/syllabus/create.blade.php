@extends('layouts.app')

@section('title')
    Create|PYQ
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
    <style>
        button.multiselect {
            width: 300px !important;
            border: 1px solid var(--cui-form-select-border-color, #b1b7c1) !important;
        }

        .dropdown-menu.show {
            width: 300px !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Create</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Add Syllabus here.</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('syllabus.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="commission_id" class="form-label">Examination Commission</label>
                        <select class="form-select" name="commission_id" id="commission_id" required>
                            <option value="" selected disabled>None</option>
                            @foreach($commissions as $commission)
                                <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                            @endforeach
                        </select>
                        @error('commission_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id" required>

                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 sub-cat hidecls">
                        <label for="sub_category_id" class="form-label">Sub Category</label>
                        <select class="form-select" name="sub_category_id" id="sub_category_id" required>

                        </select>

                    </div>
        

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" name="subject_id" id="subject_id">
                            <option value="" selected disabled>None</option>
                            <!-- Options will be dynamically loaded -->
                        </select>
                        @error('subject_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>



                    <div class="mb-3">
                        <label for="pdf" class="form-label">PDF</label>
                        <input type="file" class="form-control" name="pdf" accept="application/pdf" required>
                        @if ($errors->has('pdf'))
                            <span class="text-danger text-left">{{ $errors->first('pdf') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Detail Content</label>
                        <textarea name="detail_content" id="detail_content" class="form-control" rows="5"
                            placeholder="Enter detailed description here..."></textarea>
                        @error('detail_content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{route('syllabus.index')}}" class="btn">Back</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ClassicEditor
                .create(document.querySelector('#detail_content'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ],
                    placeholder: 'Write the detailed content here...',
                })
                .then(editor => {
                    window.detailEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        });

        $(document).ready(function () {
            $(document).on('change', '#commission_id', function (event) {

                $('#category_id').val("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html);
                        } else {
                            //toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#category_id', function (event) {

                $('#sub_category_id').val("");
                let exam_category = $(this).val();
                if (exam_category != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#sub_category_id').html(result.html);
                                    $('.sub-cat').removeClass('hidecls');
                                    $('#sub_category_id').attr("required", false);
                                }
                                else {
                                    $('#sub_category_id').val("");
                                    $('.sub-cat').addClass('hidecls');
                                    $('#sub_category_id').attr("required", false);
                                }

                            } else {
                                //toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });


                }
                else {
                    $('#sub_category_id').val("");
                    $('.sub-cat').addClass('hidecls');
                    $('#sub_category_id').attr("required", false);
                }

            });

            $('#sub_category_id').change(function () {
                var subCategoryId = $(this).val();
                if (subCategoryId) {
                    $.ajax({
                        url: "{{ route('fetch-subject-by-subcategory', ':sub_category_id') }}".replace(':sub_category_id', subCategoryId),
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#subject_id').empty();
                                $('#subject_id').append(response.html);
                            } else {
                                console.error('Error: ' + response.msgText);
                                // You can handle the error here, for example, display a message to the user
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error: ' + error);
                            // You can handle the AJAX error here, for example, display a message to the user
                        }
                    });
                } else {
                    $('#subject_id').empty();
                    $('#subject_id').append('<option value="" selected disabled>Select Subject</option>');
                }
            });

        });

    </script>
@endpush