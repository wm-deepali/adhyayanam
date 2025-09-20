@extends('layouts.app')

@section('title')
    Study Material || Create
@endsection

@section('content')

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Create Study Material here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form id="study-form" method="POST" action="{{ route('study.material.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Select Examination Commission</label>
                        <select class="form-control" name="commission_id" id="exam_com_id">
                            <option value="">--Select--</option>
                            @foreach($commissions as $commission)
                                <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">--Select--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 sub-cat hidecls">
                        <label>Sub Category</label>
                        <select class="form-control" name="sub_category_id" id="sub_category_id">
                            <option value="">--Select--</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Subject</label>
                        <select class="form-control" name="subject_id" id="subject_id">
                            <option value="">--Select--</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select Chapter</label>
                        <select class="form-control" name="chapter_id" id="chapter_id">
                            <option value="">--Select--</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select Topic</label>
                        <select class="form-control" name="topic" id="topic_id">
                            <option value="">--Select--</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" placeholder="Short Description"
                            required></textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Description</label>
                        <textarea id="editor" name="detail_content" style="height: 200px;"></textarea>
                        @if ($errors->has('detail_content'))
                            <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="IsPaid" class="form-label">Paid</label>
                        <select class="form-control" name="IsPaid" id="IsPaid" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @if ($errors->has('IsPaid'))
                            <span class="text-danger text-left">{{ $errors->first('IsPaid') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 priceField" style="display: none;">
                        <label for="mrp" class="form-label">MRP:</label>
                        <input type="number" class="form-control" id="mrp" name="mrp">
                        @if ($errors->has('mrp'))
                            <span class="text-danger text-left">{{ $errors->first('mrp') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 priceField" style="display: none;">
                        <label for="discount" class="form-label">Discount (%):</label>
                        <input type="number" class="form-control" id="discount" name="discount">
                        @if ($errors->has('discount'))
                            <span class="text-danger text-left">{{ $errors->first('discount') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 priceField" style="display: none;">
                        <label for="offered-price" class="form-label">Offered Price:</label>

                        <input type="text" class="form-control" id="offered-price" name="price" readonly>
                        @if ($errors->has('price'))
                            <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                        @endif

                    </div>
                    {{-- <div class="mb-3" id="priceField" style="display: none;">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" placeholder="Price">
                        @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                        @endif
                    </div> --}}

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inctive">Inctive</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="banner" class="form-label">Upload Banner</label>
                        <input type="file" class="form-control" name="banner" accept="image" required>
                        @if ($errors->has('banner'))
                            <span class="text-danger text-left">{{ $errors->first('banner') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="is_pdf_downloadable" class="form-label">Is PDF Downloadable?</label>
                        <select class="form-control" name="is_pdf_downloadable" id="is_pdf_downloadable" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @if ($errors->has('is_pdf_downloadable'))
                            <span class="text-danger text-left">{{ $errors->first('is_pdf_downloadable') }}</span>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                        @if ($errors->has('meta_title'))
                            <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                        <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keyword">
                        @if ($errors->has('meta_keyword'))
                            <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" placeholder="Meta Description">
                        @if ($errors->has('meta_description'))
                            <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('study.material.index') }}" class="btn">Back</a>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#exam_com_id', function (event) {

                $('#category_id').html("");
                $('#subject_id').html("");
                $('#chapter_id').html("");
                $('#topic_id').html("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html);
                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#category_id', function (event) {

                $('#sub_category_id').html("");
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
                                    $('#sub_category_id').attr("required", true);
                                }
                                else {
                                    $('#sub_category_id').val("").trigger('change');
                                    $('.sub-cat').addClass('hidecls');
                                    $('#sub_category_id').attr("required", false);
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    $('#sub_category_id').val("").trigger('change');
                    $('.sub-cat').addClass('hidecls');
                    $('#sub_category_id').attr("required", false);
                }

            });

            $(document).on('change', '#exam_com_id,#category_id,#sub_category_id', function (e) {
                e.preventDefault(e);

                $('#subject_id').val("").trigger('change');
                let competitive_commission = $('#exam_com_id').val();
                let category_id = $('#category_id').val();
                let sub_category_id = $('#sub_category_id').val();
                $.ajax({
                    headers: { "Access-Control-Allow-Origin": "*" },
                    url: `{{ URL::to('fetch-subject-by-subcategory/${sub_category_id}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#subject_id').html(result.html);
                        } else {
                            //alert(result.msgText);
                            //toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });
            $(document).on('change', '#subject_id', function (event) {

                $('#chapter_id').val("").trigger('change');
                let subject = $(this).val();
                if (subject != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#chapter_id').html(result.html);
                                }
                                else {
                                    $('#chapter_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    // $('#sub_category_id').val("").trigger('change');
                    // $('.sub-cat').addClass('hidecls');
                    // $('#sub_category_id').attr("required", false);
                }

            });
            $(document).on('change', '#chapter_id', function (event) {

                $('#topic_id').val("").trigger('change');
                let chapter = $(this).val();
                if (chapter != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#topic_id').html(result.html);
                                }
                                else {
                                    $('#topic_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }

            });
        });

        $(document).ready(function () {
            $("#IsPaid").change(function () {
                var data = $(this).val();
                if (data == 1) {
                    $(".priceField").removeAttr("style");
                } else {
                    $(".priceField").css("display", "none");
                }
            })

            function calculateOfferedPrice() {
                var mrp = parseFloat($('#mrp').val());
                var discount = parseFloat($('#discount').val());

                if (isNaN(mrp) || isNaN(discount)) {
                    $('#offered-price').val(mrp);
                    return;
                }

                var offeredPrice = mrp - (mrp * (discount / 100));
                $('#offered-price').val(offeredPrice.toFixed(2));
            }

            $('#mrp, #discount').on('input', calculateOfferedPrice);
        })
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor');

            // const IsPaidSelect = document.getElementById('IsPaid');
            // const priceField = document.getElementByclassName('priceField');

            // Function to toggle price field visibility
            // function togglePriceField() {
            //     if (IsPaidSelect.value == '1') {
            //         priceField.style.display = 'block';
            //     } else {
            //         priceField.style.display = 'none';
            //     }
            // }

            // Initial check to set the correct visibility on page load
            // togglePriceField();

            // Add event listener to toggle visibility on change
            // IsPaidSelect.addEventListener('change', togglePriceField);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // const examinationCommissionSelect = document.getElementById('category_id');
            // const categorySelect = document.getElementById('category_id');

            // examinationCommissionSelect.addEventListener('change', function() {
            //     const examinationCommissionId = this.value;
            //     if (examinationCommissionId) {
            //         fetchCategories(examinationCommissionId);
            //     }
            // });

            // function fetchCategories(examinationCommissionId) {
            //     $.ajax({
            //         url: `{{ route('settings.categories', '') }}/${examinationCommissionId}`,
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(response) {
            //             categorySelect.innerHTML = '<option value="" selected disabled>None</option>';
            //             response.categories.forEach(category => {
            //                 categorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
            //             });
            //         },
            //         error: function(error) {
            //             console.error('Error fetching categories:', error);
            //         }
            //     });
            // }
        });

        $(document).on('change', '#category_id', function (event) {

            $('#topic_id').val("");
            let category = $(this).val();
            $.ajax({
                url: `{{ URL::to('study-material/main-topic/fetch-topic-by-category/${category}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    if (result.success) {
                        $('#topic_id').html(result.html);
                    } else {
                        //toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });
    </script>
@endsection