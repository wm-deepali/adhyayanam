@extends('layouts.app')

@section('title')
    Edit | Course
@endsection
@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Edit</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Edit Course here.</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('courses.course.update', $course->id) }}" id="course-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="feature" class="form-label">Feature</label>
                                <input class="form-control" id="feature" name="feature" @if($course->feature == 'on') checked
                                @endif type="checkbox" data-toggle="toggle" data-onstyle="success"
                                    data-offstyle="danger" data-width="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="examination_commission_id" class="form-label">Course Type</label>
                                <select class="form-select" name="examination_commission_id" id="examination_commission_id"
                                    required>
                                    <option value="" disabled>None</option>
                                    @foreach($examinationCommissions as $commission)
                                        <option value="{{ $commission->id }}" {{ $commission->id == $course->examination_commission_id ? 'selected' : '' }}>
                                            {{ $commission->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('examination_commission_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" name="category_id" id="category_id" required>
                                    <option value="{{$course->category->id}}" selected>{{$course->category->name}}</option>
                                    <!-- Options will be dynamically loaded -->
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_category_id" class="form-label">Sub Category</label>
                                <select class="form-select" name="sub_category_id" id="sub_category_id">
                                    <option value="{{$course->subCategory->id}}" selected>{{$course->subCategory->name}}
                                    </option>
                                    <!-- Options will be dynamically loaded -->
                                </select>
                                @error('sub_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Course Name"
                                    value="{{ $course->name }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Add more fields here -->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject</label>
                                <select class="form-control select2" name="subject_id[]" id="subject_id" multiple>
                                    @php
                                        $selectedSubjects = $course->subject_id ?? [];
                                    @endphp
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ in_array($subject->id, $selectedSubjects) ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="chapter_id" class="form-label">Chapter</label>
                                <select class="form-control select2" name="chapter_id[]" id="chapter_id" multiple>
                                    @php
                                        $selectedChapters = $course->chapter_id ?? [];
                                    @endphp
                                    @foreach($chapters as $chapter)
                                        <option value="{{ $chapter->id }}" {{ in_array($chapter->id, $selectedChapters) ? 'selected' : '' }}>
                                            {{ $chapter->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('chapter_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="topic_id" class="form-label">Topic</label>
                                <select class="form-control select2" name="topic_id[]" id="topic_id" multiple>
                                    @php
                                        $selectedTopics = $course->topic_id ?? [];
                                    @endphp
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ in_array($topic->id, $selectedTopics) ? 'selected' : '' }}>
                                            {{ $topic->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('topic_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="based_on" id="based_on" value="">
                            <div class="alert alert-info mt-2" id="based-on-text" style="display:none;">
                                <strong>Based On:</strong> <span id="based-on-value"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" placeholder="Duration"
                                    value="{{ $course->duration }}" required>
                                @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_fee" class="form-label">Fee</label>
                                <input type="number" class="form-control" name="course_fee" placeholder="Fee"
                                    value="{{ $course->course_fee }}" required>
                                @error('course_fee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" class="form-control" name="discount" placeholder="Discount"
                                    value="{{ $course->discount }}" required>
                                @error('discount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="offered_price" class="form-label">Offered Price</label>
                                <input type="number" class="form-control" name="offered_price" placeholder="Offered Price"
                                    value="{{ $course->offered_price }}" required>
                                @error('offered_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="num_classes" class="form-label">Number Of Classes</label>
                                <input type="number" class="form-control" name="num_classes" placeholder="Number Of Classes"
                                    value="{{ $course->num_classes }}" required>
                                @error('num_classes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="num_topics" class="form-label">Number Of Topics</label>
                                <input type="number" class="form-control" name="num_topics" placeholder="Number Of Topics"
                                    value="{{ $course->num_topics }}" required>
                                @error('num_topics')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="language_of_teaching" class="form-label">Languages</label>
                                <select class="form-control select2" name="language_of_teaching[]" multiple="multiple">
                                    <option value="{{$course->language_of_teaching[0]}}" selected>
                                        {{$course->language_of_teaching}}
                                    </option>
                                </select>
                                @error('language_of_teaching')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_heading" class="form-label">Heading*</label>
                                <input type="text" class="form-control" name="course_heading" placeholder="Heading"
                                    value="{{ $course->course_heading }}" required>
                                @error('course_heading')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <input type="text" class="form-control" name="short_description"
                                    placeholder="Short Description" value="{{ $course->short_description }}" required>
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="thumbnail_image" class="form-label">Upload Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail_image" id="thumbnail_image"
                                    accept="image/*">
                                <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="Thumbnail" width="100">
                                @if ($errors->has('thumbnail_image'))
                                    <span class="text-danger text-left">{{ $errors->first('thumbnail_image') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="course_overview" class="form-label">Course Overview*</label>
                        <textarea id="course_overview" name="course_overview"
                            style="height: 300px;">{{ $course->course_overview }}</textarea>
                        @error('course_overview')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Course Detail*</label>
                        <textarea id="detail_content" name="detail_content"
                            style="height: 200px;">{{ $course->detail_content }}</textarea>
                        @error('detail_content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="banner_image" class="form-label">Upload Banner</label>
                                <input type="file" class="form-control" name="banner_image" id="banner_image"
                                    accept="image/*">
                                <img src="{{ asset('storage/' . $course->banner_image) }}" alt="Banner" width="100">
                                @if ($errors->has('banner_image'))
                                    <span class="text-danger text-left">{{ $errors->first('banner_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="youtube_url" class="form-label">Youtube Video Url</label>
                                <input type="text" class="form-control" name="youtube_url" placeholder="Youtube Video Url"
                                    value="{{ $course->youtube_url }}" required>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title"
                                    value="{{ $course->meta_title }}" required>
                                @error('meta_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_keyword" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Tag, Tag"
                                    value="{{ $course->meta_keyword }}" required>
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
                                <input type="text" class="form-control" name="meta_description"
                                    placeholder="Meta Description" value="{{ $course->meta_description }}" required>
                                @error('meta_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_alt_tag" class="form-label">Alt Tag</label>
                                <input type="text" class="form-control" name="image_alt_tag" placeholder="Tag"
                                    value="{{ $course->image_alt_tag }}" required>
                                @error('image_alt_tag')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('courses.course.index') }}" class="btn">Back</a>
                </form>
            </div>
        </div>
    </div>
   {{-- In your Blade file or master layout --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    {{-- In your Blade file or master layout --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            CKEDITOR.replace('detail_content');
            CKEDITOR.replace('course_overview');
            setInterval(function () {
                $(document).find(".cke_notifications_area").remove();
            }, 100);


            if ($.fn.select2) {
                $('.select2').select2({
                    width: '100%',
                    placeholder: '--Select--',
                    allowClear: true
                });
            } else {
                console.error("❌ Select2 not loaded!");
            }

            // ✅ Initialize Language of Teaching dropdown
            const languages = ["English", "Hindi"];

            $('select[name="language_of_teaching[]"]').select2({
                width: '100%',
                placeholder: 'Select Languages',
                data: languages.map(lang => ({ id: lang, text: lang })), // preload options
                tags: true, // allow adding new custom entries
                tokenSeparators: [',', ' '],
                maximumSelectionLength: 5,
                allowClear: true
            });

            const examinationCommissionSelect = document.getElementById('examination_commission_id');
            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');

             // On Subcategory change -> fetch Subjects
            $('#sub_category_id').on('change', function () {
                let subCategoryId = $(this).val();
                if (subCategoryId) {
                    $.ajax({
                        url: '/fetch-subject-by-subcategory/' + subCategoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                $('#subject_id').html(result.html).trigger('change');
                            } else {
                                $('#subject_id').html('<option value="">--Select--</option>').trigger('change');
                            }
                        }
                    });
                } else {
                    $('#subject_id').html('<option value="">--Select--</option>').trigger('change');
                    $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                }
            });

            // On Subject change -> fetch Chapters
            $('#subject_id').on('change', function () {
                let subjects = $(this).val();
                console.log('here', subjects);

                if (subjects && subjects.length > 0) {
                    $.ajax({
                        url: '/fetch-chapter-by-subject/' + subjects.join(','),
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                $('#chapter_id').html(result.html).trigger('change');
                            } else {
                                $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                            }
                        }
                    });
                } else {
                    $('#chapter_id').html('<option value="">--Select--</option>').trigger('change');
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                }
            });

            // On Chapter change -> fetch Topics
            $('#chapter_id').on('change', function () {
                let chapters = $(this).val();
                if (chapters && chapters.length > 0) {
                    $.ajax({
                        url: '/fetch-topic-by-chapter/' + chapters.join(','),
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                $('#topic_id').html(result.html).trigger('change');
                            } else {
                                $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                            }
                        }
                    });
                } else {
                    $('#topic_id').html('<option value="">--Select--</option>').trigger('change');
                }
            });


           // Initialize Based On on page load from PHP model value
    let initialBasedOn = @json($course->based_on ?? '');
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

            examinationCommissionSelect.addEventListener('change', function () {
                const examinationCommissionId = this.value;
                if (examinationCommissionId) {
                    fetchCategories(examinationCommissionId);
                }
            });

            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;
                if (categoryId) {
                    fetchSubCategories(categoryId);
                }
            });

            function fetchCategories(examinationCommissionId) {
                $.ajax({
                    url: `{{ route('settings.categories', '') }}/${examinationCommissionId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        categorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                        response.categories.forEach(category => {
                            categorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching categories:', error);
                    }
                });
            }

            function fetchSubCategories(categoryId) {
                $.ajax({
                    url: `{{ route('settings.subcategories', '') }}/${categoryId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        subCategorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                        response.subcategories.forEach(subcategory => {
                            subCategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching subcategories:', error);
                    }
                });
            }
        });
    </script>
@endsection