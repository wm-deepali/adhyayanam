@extends('layouts.app')

@section('title')
    Study Material || Create
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create</h5>
                <h6 class="card-subtitle mb-2 text-muted">Create Study Material here.</h6>

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
                        <select class="form-control select2" name="subject_id[]" id="subject_id" multiple>
                            <option value="">--Select--</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Chapter</label>
                        <select class="form-control select2" name="chapter_id[]" id="chapter_id" multiple>
                            <option value="">--Select--</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Topic</label>
                        <select class="form-control select2" name="topic_id[]" id="topic_id" multiple>
                            <option value="">--Select--</option>
                        </select>
                    </div>

                    <input type="hidden" name="based_on" id="based_on" value="">
                    <div class="alert alert-info mt-2" id="based-on-text" style="display:none;">
                        <strong>Based On:</strong> <span id="based-on-value"></span>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Study Material Heading</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" required>
                        @error('title') <span class="text-danger text-left">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" placeholder="Short Description"
                            required></textarea>
                        @error('short_description') <span class="text-danger text-left">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Detail Content</label>
                        <textarea id="editor" name="detail_content" style="height: 200px;"></textarea>
                        @error('detail_content') <span class="text-danger text-left">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title & Description</label>

                        <div id="title-description-wrapper">
                            <div class="title-description-group mb-2 border rounded p-2">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="titles[]" placeholder="Title"
                                            required>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <textarea class="form-control description-editor" id="desc-editor-1"
                                            name="descriptions[]" placeholder="Description" rows="3" required></textarea>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                         <button type="button" class="btn btn-danger btn-sm remove-group">Remove</button>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-more-group" class="btn btn-success btn-sm mt-2">
                            <i class="fa fa-plus"></i> Add More
                        </button>
                    </div>



                    <div class="mb-3">
                        <label for="IsPaid" class="form-label">Paid</label>
                        <select class="form-control select2" name="IsPaid" id="IsPaid" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('IsPaid') <span class="text-danger text-left">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3 priceField" style="display: none;">
                        <label for="mrp" class="form-label">MRP:</label>
                        <input type="number" class="form-control" id="mrp" name="mrp">
                    </div>

                    <div class="mb-3 priceField" style="display: none;">
                        <label for="discount" class="form-label">Discount (%):</label>
                        <input type="number" class="form-control" id="discount" name="discount">
                    </div>

                    <div class="mb-3 priceField" style="display: none;">
                        <label for="offered-price" class="form-label">Offered Price:</label>
                        <input type="text" class="form-control" id="offered-price" name="price" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control select2" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="banner" class="form-label">Upload Banner</label>
                        <input type="file" class="form-control" name="banner" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="is_pdf_downloadable" class="form-label">Is PDF Downloadable?</label>
                        <select class="form-control select2" name="is_pdf_downloadable" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                        <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keyword">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" placeholder="Meta Description">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('study.material.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    {{-- In your Blade file or master layout --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('editor');
            if ($.fn.select2) {
                $('.select2').select2({
                    width: '100%',
                    placeholder: '--Select--',
                    allowClear: true
                });
            } else {
                console.error("❌ Select2 not loaded!");
            }
            // rest of your JS...

            // AJAX dependent dropdowns (same logic, with select2 updates)
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
                let subject = $(this).val();

                if (subject && subject.length > 0) {
                    // Only reset and fetch chapters if subjects are selected
                    $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                    $.ajax({
                        url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success && result.html) {
                                $('#chapter_id').html(result.html);
                            } else {
                                $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                            }
                        },
                    });
                } else {
                    // 🧹 If all subjects are cleared, just clear chapters and topics
                    $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                }
            });

            $(document).on('change', '#chapter_id', function (event) {
                let chapter = $(this).val();

                if (chapter && chapter.length > 0) {
                    // Only reset and fetch topics if chapters are selected
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');

                    $.ajax({
                        url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success && result.html) {
                                $('#topic_id').html(result.html);
                            } else {
                                $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                            }
                        },
                    });
                } else {
                    // 🧹 If all chapters are cleared, just clear topics quietly
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                }
            });

            $(document).on('change', '#sub_category_id, #subject_id, #chapter_id, #topic_id', function () {
                let subCategory = $('#sub_category_id').val();
                let subjects = $('#subject_id').val() || [];
                let chapters = $('#chapter_id').val() || [];
                let topics = $('#topic_id').val() || [];

                let basedOn = '';

                // Helper functions to enable/disable Select2 properly
                // Helper functions to enable/disable Select2 properly
                const disableSelect2 = (selector) => {
                    // Disable native select
                    $(selector).prop('disabled', true);

                    // Disable select2 interface
                    $(selector).next(".select2-container").addClass("select2-disabled");
                    $(selector).select2({ disabled: true });

                    // Visually grey out
                    $(selector).next('.select2-container').css({
                        'pointer-events': 'none',
                        'opacity': '0.6'
                    });
                };

                const enableSelect2 = (selector) => {
                    $(selector).prop('disabled', false);
                    $(selector).select2({ disabled: false });
                    $(selector).next('.select2-container').removeClass("select2-disabled");
                    $(selector).next('.select2-container').css({
                        'pointer-events': '',
                        'opacity': ''
                    });
                };


                // Enable Chapter and Topic initially
                enableSelect2('#chapter_id');
                enableSelect2('#topic_id');

                if (subjects.length === 0 && subCategory) {
                    basedOn = 'Sub Category Based';
                }
                else if (subjects.length === 1 && chapters.length === 0) {
                    basedOn = 'Subject Based';
                }
                else if (subjects.length > 1) {
                    basedOn = 'Combined Subject Based';

                    // Disable Chapter and Topic selects when more than one subject selected
                    disableSelect2('#chapter_id');
                    disableSelect2('#topic_id');
                }
                else if (chapters.length === 1 && topics.length === 0) {
                    basedOn = 'Chapter Based';
                }
                else if (chapters.length > 1 && topics.length === 0) {
                    basedOn = 'Combined Chapter Based';

                    // Disable Topic select when more than one chapter selected
                    disableSelect2('#topic_id');
                }
                else if (topics.length >= 1) {
                    basedOn = (topics.length > 1) ? 'Combined Topic Based' : 'Topic Based';
                }

                $('#based_on').val(basedOn);
                if (basedOn) {
                    $('#based-on-value').text(basedOn);
                    $('#based-on-text').show();
                } else {
                    $('#based-on-text').hide();
                }
            });

            // 💰 Price Logic
            $("#IsPaid").change(function () {
                var val = $(this).val();
                $(".priceField").toggle(val == 1);
            });

            $('#mrp, #discount').on('input', function () {
                var mrp = parseFloat($('#mrp').val());
                var discount = parseFloat($('#discount').val());
                if (isNaN(mrp) || isNaN(discount)) {
                    $('#offered-price').val('');
                    return;
                }
                var offeredPrice = mrp - (mrp * (discount / 100));
                $('#offered-price').val(offeredPrice.toFixed(2));
            });
        });
        
let descEditorCount = 1; // track number of CKEditor instances

// Initialize CKEditor for the first description
CKEDITOR.replace('desc-editor-1');

// Add More / Remove functionality for Title & Description
$(document).on('click', '#add-more-group', function () {
    descEditorCount++;
    const newEditorId = `desc-editor-${descEditorCount}`;

    const newGroup = `
        <div class="title-description-group mb-2 border rounded p-2">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <input type="text" class="form-control" name="titles[]" placeholder="Title" required>
                </div>
                <div class="col-md-12 mb-2">
                    <textarea class="form-control description-editor" id="${newEditorId}" name="descriptions[]" placeholder="Description" rows="3" required></textarea>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <div class="col-md-1 d-flex align-items-center">
                                         <button type="button" class="btn btn-danger btn-sm remove-group">Remove</button>
                                       
                                    </div>
                </div>
            </div>
        </div>`;

    $('#title-description-wrapper').append(newGroup);

    // Initialize CKEditor for the new textarea
    CKEDITOR.replace(newEditorId);
});

// Remove specific group (with CKEditor cleanup)
$(document).on('click', '.remove-group', function () {
    const textarea = $(this).closest('.title-description-group').find('textarea');
    const editorId = textarea.attr('id');

    // Destroy CKEditor instance safely
    if (CKEDITOR.instances[editorId]) {
        CKEDITOR.instances[editorId].destroy(true);
    }

    $(this).closest('.title-description-group').remove();
});

// ✅ Ensure CKEditor content is synced to textarea before submitting form
$('#study-form').on('submit', function () {
    for (let instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
});


    </script>
@endsection