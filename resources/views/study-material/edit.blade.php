@extends('layouts.app')

@section('title')
    Study Material || Edit
@endsection

@section('content')

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit</h5>
                <h6 class="card-subtitle mb-2 text-muted">Edit Study Material here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form id="study-form" method="POST" action="{{ route('study.material.update', $material->id) }}"
                    enctype="multipart/form-data">
                    @csrf



                    <div class="mb-3">
                        <label>Select Examination Commission</label>
                        <select class="form-control select2" name="commission_id" id="exam_com_id" required>
                            <option value="">--Select--</option>
                            @foreach($commissions as $commission)
                                <option value="{{ $commission->id }}" {{ $material->commission_id == $commission->id ? 'selected' : '' }}>
                                    {{ $commission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select Category</label>
                        <select class="form-control select2" name="category_id" id="category_id" required>
                            <option value="">--Select--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $material->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 sub-cat">
                        <label>Sub Category</label>
                        <select class="form-control select2" name="sub_category_id" id="sub_category_id">
                            <option value="">--Select--</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $material->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Subject</label>
                        <select class="form-control select2" name="subject_id[]" id="subject_id" multiple>
                            @php
                                $selectedSubjects = $material->subject_id ?? [];
                            @endphp
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ in_array($subject->id, $selectedSubjects) ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Chapter</label>
                        <select class="form-control select2" name="chapter_id[]" id="chapter_id" multiple>
                            @php
                                $selectedChapters = $material->chapter_id ?? [];
                            @endphp
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ in_array($chapter->id, $selectedChapters) ? 'selected' : '' }}>
                                    {{ $chapter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Select Topic</label>
                        <select class="form-control select2" name="topic_id[]" id="topic_id" multiple>
                            @php
                                $selectedTopics = $material->topic_id ?? [];
                            @endphp
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ in_array($topic->id, $selectedTopics) ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                     <input type="hidden" name="based_on" id="based_on" value="">
                    <div class="alert alert-info mt-2" id="based-on-text" style="display:none;">
                        <strong>Based On:</strong> <span id="based-on-value"></span>
                    </div>


                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $material->title }}"
                            placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description"
                            required>{{ $material->short_description }}</textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Description</label>
                        <textarea id="editor" name="detail_content"
                            style="height: 200px;">{!! $material->detail_content !!}</textarea>
                        @if ($errors->has('detail_content'))
                            <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="IsPaid" class="form-label">Paid</label>
                        <select class="form-control" name="IsPaid" id="IsPaid" required>
                            <option value="0" {{ $material->IsPaid == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $material->IsPaid == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                        @if ($errors->has('IsPaid'))
                            <span class="text-danger text-left">{{ $errors->first('IsPaid') }}</span>
                        @endif
                    </div>

                    <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                        <label for="mrp" class="form-label">MRP:</label>
                        <input type="number" class="form-control" id="mrp" name="mrp" value="{{ $material->mrp }}">
                        @if ($errors->has('mrp'))
                            <span class="text-danger text-left">{{ $errors->first('mrp') }}</span>
                        @endif
                    </div>

                    <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                        <label for="discount" class="form-label">Discount (%):</label>
                        <input type="number" class="form-control" id="discount" name="discount"
                            value="{{ $material->discount }}">
                        @if ($errors->has('discount'))
                            <span class="text-danger text-left">{{ $errors->first('discount') }}</span>
                        @endif
                    </div>

                    <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                        <label for="offered-price" class="form-label">Offered Price:</label>
                        <input type="text" class="form-control" id="offered-price" name="price"
                            value="{{ $material->price }}" readonly>
                        @if ($errors->has('price'))
                            <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="Active" {{ $material->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $material->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="banner" class="form-label">Upload Banner</label>
                        <input type="file" class="form-control" name="banner" accept="image/*">
                        @if ($errors->has('banner'))
                            <span class="text-danger text-left">{{ $errors->first('banner') }}</span>
                        @endif
                        @if ($material->banner)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $material->banner) }}" alt="Current Banner"
                                    style="height: 100px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_pdf_downloadable"
                            name="is_pdf_downloadable" value="1" {{ $material->is_pdf_downloadable ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_pdf_downloadable">PDF Downloadable</label>
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $material->meta_title }}"
                            placeholder="Meta Title">
                        @if ($errors->has('meta_title'))
                            <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keyword</label>
                        <input type="text" class="form-control" name="meta_keyword" value="{{ $material->meta_keyword }}"
                            placeholder="Meta Keyword">
                        @if ($errors->has('meta_keyword'))
                            <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description"
                            value="{{ $material->meta_description }}" placeholder="Meta Description">
                        @if ($errors->has('meta_description'))
                            <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('study.material.index') }}" class="btn">Back</a>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>

        function updateDisableSelects() {
    let subjects = $('#subject_id').val() || [];
    let chapters = $('#chapter_id').val() || [];

    // Enable all by default
    $('#chapter_id').prop('disabled', false).trigger('change.select2');
    $('#topic_id').prop('disabled', false).trigger('change.select2');

    if (subjects.length > 1) {
        $('#chapter_id').val(null).trigger('change');
        $('#chapter_id').prop('disabled', true).trigger('change.select2');
        $('#topic_id').val(null).trigger('change');
        $('#topic_id').prop('disabled', true).trigger('change.select2');
    } else if (chapters.length > 1) {
        $('#topic_id').val(null).trigger('change');
        $('#topic_id').prop('disabled', true).trigger('change.select2');
    }
}

        $(document).ready(function () {
            
            // Initialize Select2 on all selects with .select2 class
            $('.select2').select2({
                width: '100%',
                placeholder: '--Select--',
                allowClear: true
            });

// Initialize Based On on page load from PHP model value
    let initialBasedOn = @json($material->based_on ?? '');
    if (initialBasedOn) {
        $('#based_on').val(initialBasedOn);
        $('#based-on-value').text(initialBasedOn);
        $('#based-on-text').show();
    } else {
        $('#based-on-text').hide();
    }

              updateDisableSelects();

    // Bind to change events
    $('#subject_id, #chapter_id').on('change', function() {
        updateDisableSelects();
   let subCategory = $('#sub_category_id').val();

let subjects = $('#subject_id').val();
if (!Array.isArray(subjects)) subjects = subjects ? [subjects] : [];

let chapters = $('#chapter_id').val();
if (!Array.isArray(chapters)) chapters = chapters ? [chapters] : [];

let topics = $('#topic_id').val();
if (!Array.isArray(topics)) topics = topics ? [topics] : [];

let basedOn = '';

if (subjects.length === 0 && subCategory) {
    basedOn = 'Sub Category Based';
} else if (subjects.length > 1) {
    basedOn = 'Combined Subject Based';
} else if (subjects.length === 1 && chapters.length === 0) {
    basedOn = 'Subject Based';
} else if (chapters.length > 1 && topics.length === 0) {
    basedOn = 'Combined Chapter Based';
} else if (chapters.length === 1 && topics.length === 0) {
    basedOn = 'Chapter Based';
} else if (topics.length >= 1) {
    basedOn = (topics.length > 1) ? 'Combined Topic Based' : 'Topic Based';
} else {
    basedOn = '';
}

$('#based_on').val(basedOn);
if (basedOn) {
    $('#based-on-value').text(basedOn);
    $('#based-on-text').show();
} else {
    $('#based-on-text').hide();
}

    });


            // Chained dropdown AJAX updates on edit
            $(document).on('change', '#exam_com_id', function () {
                let commission = $(this).val();
                $('#category_id').html('').trigger('change');
                $('#sub_category_id').html('').trigger('change');
                $('#subject_id').html('').trigger('change');
                $('#chapter_id').html('').trigger('change');
                $('#topic_id').html('').trigger('change');
                if (commission) {
                    $.get(`{{ url('fetch-exam-category-by-commission') }}/${commission}`, function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html).trigger('change');
                        }
                    });
                }
            });

            $(document).on('change', '#category_id', function () {
                let category = $(this).val();
                $('#sub_category_id').html('').trigger('change');
                $('#subject_id').html('').trigger('change');
                $('#chapter_id').html('').trigger('change');
                $('#topic_id').html('').trigger('change');
                if (category) {
                    $.get(`{{ url('fetch-sub-category-by-exam-category') }}/${category}`, function (result) {
                        if (result.success) {
                            if (result.html) {
                                $('#sub_category_id').html(result.html).trigger('change');
                                $('.sub-cat').removeClass('hidecls');
                            } else {
                                $('.sub-cat').addClass('hidecls');
                            }
                        }
                    });
                }
            });

            $(document).on('change', '#sub_category_id', function () {
                let subcat = $(this).val();
                $('#subject_id').html('').trigger('change');
                $('#chapter_id').html('').trigger('change');
                $('#topic_id').html('').trigger('change');
                if (subcat) {
                    $.get(`{{ url('fetch-subject-by-subcategory') }}/${subcat}`, function (result) {
                        if (result.success) {
                            $('#subject_id').html(result.html).trigger('change');
                        }
                    });
                }
            });

            $(document).on('change', '#subject_id', function () {
                let subject = $(this).val();
                $('#chapter_id').html('').trigger('change');
                $('#topic_id').html('').trigger('change');
                if (subject) {
                    $.get(`{{ url('fetch-chapter-by-subject') }}/${subject}`, function (result) {
                        if (result.success) {
                            $('#chapter_id').html(result.html).trigger('change');
                        }
                    });
                }
            });

            $(document).on('change', '#chapter_id', function () {
                let chapter = $(this).val();
                $('#topic_id').html('').trigger('change');
                if (chapter) {
                    $.get(`{{ url('fetch-topic-by-chapter') }}/${chapter}`, function (result) {
                        if (result.success) {
                            $('#topic_id').html(result.html).trigger('change');
                        }
                    });
                }
            });

            // Show/hide price fields based on paid select
            $("#IsPaid").change(function () {
                if ($(this).val() == 1) {
                    $(".priceField").show();
                } else {
                    $(".priceField").hide();
                }
            }).trigger('change');

            // Calculate offered price dynamically
            function calculateOfferedPrice() {
                let mrp = parseFloat($('#mrp').val());
                let discount = parseFloat($('#discount').val());
                if (isNaN(mrp)) mrp = 0;
                if (isNaN(discount)) discount = 0;
                let offeredPrice = mrp - (mrp * (discount / 100));
                $('#offered-price').val(offeredPrice.toFixed(2));
            }
            $('#mrp, #discount').on('input', calculateOfferedPrice);
            calculateOfferedPrice();

            // Initialize CKEditor
            CKEDITOR.replace('editor');
        });
    </script>
@endsection
