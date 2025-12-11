@extends('layouts.app')

@section('title', 'Manage Video')

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create</h5>
                <h6 class="card-subtitle mb-2 text-muted">Create Current Affairs here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="categoryForm" enctype="multipart/form-data">
                    @csrf
                    @if(isset($video) && $video->id) @method('PUT') @endif

                    <div class="row mx-1">

                        {{-- Type --}}
                        <div class="col-md-6 mb-2">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">Select Type</option>
                                <option value="video" {{ ($video->type ?? '') == "video" ? 'selected' : '' }}>Video</option>
                                <option value="live_class" {{ ($video->type ?? '') == "live_class" ? 'selected' : '' }}>Live
                                    Class</option>
                            </select>
                            <div class="text-danger validation-err" id="type-err"></div>
                        </div>

                        {{-- Examination Commission --}}
                        <div class="col-md-6 mb-2">
                            <label for="courseType">Examination Commission:</label>
                            <select class="form-control" name="course_type" id="courseType">
                                <option value="">Select Examination Commission</option>
                                @foreach(\App\Models\ExaminationCommission::all() as $commission)
                                    <option value="{{ $commission->id }}" {{ ($video->course_type ?? '') == $commission->id ? 'selected' : '' }}>
                                        {{ $commission->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="course_type-err"></div>
                        </div>

                        {{-- Course Category --}}
                        <div class="col-md-6 mb-2">
                            <label for="courseCategory">Select Course Category:</label>
                            <select class="form-control" name="course_category" id="courseCategory">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($video->course_category ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="course_category-err"></div>
                        </div>

                        {{-- Sub Category --}}
                        <div class="col-md-6 mb-2">
                            <label for="sub_category_id">Select Sub Category</label>
                            <select class="form-select" name="sub_category_id" id="sub_category_id">
                                @foreach($subCategories as $category)
                                    <option value="{{ $category->id }}" {{ ($video->sub_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Course --}}
                        <div class="col-md-6 mb-2">
                            <label for="course">Select Course:</label>
                            <select class="form-control" name="course" id="course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ ($video->course_id ?? '') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="course-err"></div>
                        </div>

                        {{-- Subject, Chapter, Topic --}}
                        <div class="col-md-6 mb-2">
                            <label>Select Subject</label>
                            <select class="form-control" name="subject_id" id="subject_id">
                                <option value="">--Select--</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Select Chapter</label>
                            <select class="form-control" name="chapter_id" id="chapter_id">
                                <option value="">--Select--</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Select Topic</label>
                            <select class="form-control" name="topic_id" id="topic_id">
                                <option value="">--Select--</option>
                            </select>
                        </div>



                        {{-- Access Till & No of Views (Video Only) --}}
                        <div class="col-md-6 mb-2 wa"
                            style="{{ ($video->type ?? '') == 'live_class' ? 'display:none;' : '' }}">
                            <label>Access Till</label>
                            <input type="date" class="form-control" id="access_till" name="access_till"
                                value="{{ old('access_till', $video->access_till ?? '') }}">
                            <div class="text-danger validation-err" id="access_till-err"></div>
                        </div>

                        <div class="col-md-6 mb-2 video_div"
                            style="{{ ($video->type ?? '') == 'live_class' ? 'display:none;' : '' }}">
                            <label>No. Of times can view</label>
                            <input type="number" class="form-control" id="no_of_times_can_view" name="no_of_times_can_view"
                                value="{{ old('no_of_times_can_view', $video->no_of_times_can_view ?? '') }}">
                            <div class="text-danger validation-err" id="no_of_times_can_view-err"></div>
                        </div>

                                  {{-- Title & Slug --}}
                        <div class="col-md-6 mb-2">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $video->title ?? '') }}">
                            <div class="text-danger validation-err" id="title-err"></div>
                        </div>

                        <div class="col-md-6 mb-2" style="{{ ($video->type ?? '') == 'live_class' ? 'display:none;' : '' }}">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ old('slug', $video->slug ?? '') }}">
                            <div class="text-danger validation-err" id="slug-err"></div>
                        </div>

                        {{-- Video Container --}}
                        <div class="video-container" style="{{ ($video->type ?? '') != 'video' ? 'display:none;' : '' }}">
                            <h5>Video Details</h5>
                            <div id="videoWrapper">
                                <div class="video-block border p-3 mb-3">
                                    <div class="row">
                                        {{-- Thumb Image --}}
                                       <div class="col-md-6 mb-2">
                                    <label>Thumb Image:</label>
                                    <img id="live_thumb_preview"
                                        src="{{ isset($video) && $video->image ? asset('storage/' . $video->image) : '#' }}"
                                        style="max-width:200px; margin-bottom:10px; {{ !isset($video->image) ? 'display:none;' : '' }}">
                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                    <div class="text-danger validation-err" id="image-err"></div>
                                </div>

                                {{-- Cover Image --}}
                                <div class="col-md-6 mb-2">
                                    <label>Cover Image:</label>
                                    <img id="live_cover_preview"
                                        src="{{ isset($video) && $video->cover_image ? asset('storage/' . $video->cover_image) : '#' }}"
                                        style="max-width:200px; margin-bottom:10px; {{ !isset($video->cover_image) ? 'display:none;' : '' }}">
                                    <input type="file" class="form-control-file" id="cover_image" name="cover_image"
                                        accept="image/*">
                                    <div class="text-danger validation-err" id="cover_image-err"></div>
                                </div>

                                {{-- Assignment --}}
                                <div class="col-md-6 mb-2">
                                    <label>Assignment Image (optional):</label>
                                    <img id="live_assignment_preview"
                                        src="{{ isset($video) && $video->assignment ? asset('storage/' . $video->assignment) : '#' }}"
                                        style="max-width:200px; margin-bottom:10px; {{ !isset($video->assignment) ? 'display:none;' : '' }}">
                                    <input type="file" class="form-control-file" id="assignment" name="assignment">
                                    <div class="text-danger validation-err" id="assignment-err"></div>
                                </div>


                                        {{-- Video Type --}}
<div class="col-md-6 mb-2">
    <label>Video Type:</label>
    <select class="form-control video_type" name="video_type" id="video_type">
        <option value="">Select Video Type</option>
        <option value="YouTube" {{ (old('video_type', $video->video_type ?? '') == 'YouTube') ? 'selected' : '' }}>YouTube</option>
        <option value="Vimeo" {{ (old('video_type', $video->video_type ?? '') == 'Vimeo') ? 'selected' : '' }}>Vimeo</option>
        <option value="Storage" {{ (old('video_type', $video->video_type ?? '') == 'Storage') ? 'selected' : '' }}>Storage</option>
        <option value="Other" {{ (old('video_type', $video->video_type ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
    </select>
</div>

{{-- Video File & URL --}}
<div class="col-md-6 mb-2 video_file_div" style="display:none">
    <label>Video File:</label>
    <input type="file" class="form-control" name="video_file">
</div>

<div class="col-md-6 mb-2 video_url_div" style="display:none">
    <label>Video URL:</label>
    <input type="text" class="form-control" name="video_url"
        value="{{ old('video_url', $video->video_url ?? '') }}">
</div>

{{-- Duration --}}
<div class="col-md-6 mb-2 video_duration_div" style="display:none">
    <label>Duration:</label>
    <input type="text" class="form-control" name="duration"
        value="{{ old('duration', $video->duration ?? '') }}">
</div>

{{-- Status --}}
<div class="col-md-6 mb-2">
    <label>Status:</label>
    <select class="form-control" name="status" id="status">
        <option value="active" {{ (old('video_status', $video->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="block" {{ (old('video_status', $video->status ?? '') == 'block') ? 'selected' : '' }}>Inactive</option>
    </select>
</div>


                                        {{-- Content --}}
                                        <div class="col-md-12 mb-2">
                                    <label>Content</label>
                                    <textarea class="form-control" id="content" name="content"
                                        rows="3">{{ old('content', $video->content ?? '') }}</textarea>
                                    <div class="text-danger validation-err" id="content-err"></div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Live Class Container --}}
                        <div class="live-container"
                            style="{{ ($video->type ?? '') != 'live_class' ? 'display:none;' : '' }}">
                            <h5>Live Class Details</h5>
                            <div class="row">
                        

                                {{-- Assignment --}}
                                <div class="col-md-6 mb-2">
                                    <label>Assignment Image (optional):</label>
                                    <img id="live_assignment_preview"
                                        src="{{ isset($video) && $video->assignment ? asset('storage/' . $video->assignment) : '#' }}"
                                        style="max-width:200px; margin-bottom:10px; {{ !isset($video->assignment) ? 'display:none;' : '' }}">
                                    <input type="file" class="form-control-file" id="assignment" name="assignment">
                                    <div class="text-danger validation-err" id="assignment-err"></div>
                                </div>

                                {{-- Schedule, Start, End --}}
                                <div class="col-md-6 mb-2">
                                    <label>Schedule Date:</label>
                                    <input type="date" class="form-control" id="schedule_date" name="schedule_date"
                                        value="{{ $video->schedule_date ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label>Start Time:</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time"
                                        value="{{ $video->start_time ?? '' }}">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label>End Time:</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time"
                                        value="{{ $video->end_time ?? '' }}">
                                </div>

                                {{-- Teacher --}}
                                <div class="col-md-6 mb-2">
                                    <label>Select Teacher:</label>
                                    <select class="form-control" name="teacher" id="teacher">
                                        <option value="">Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ isset($video) && $video->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                 <!-- Live Class Link -->
                        <div class="col-md-6 mb-2">
                            <label for="live_link">Live Class Link (URL):</label>
                            <input type="url" class="form-control" name="live_link"
                            value="{{ $video->live_link }}"
                                placeholder="Enter live class URL">
                        </div>


                                {{-- Status --}}
                                <div class="col-md-6 mb-2">
                                    <label>Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="active" {{ isset($video) && $video->status == "active" ? 'selected' : '' }}>Active</option>
                                        <option value="block" {{ isset($video) && $video->status == "block" ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="text-danger validation-err" id="status-err"></div>
                                </div>

                                {{-- Content --}}
                                <div class="col-md-12 mb-2">
                                    <label>Content</label>
                                    <textarea class="form-control" id="content" name="content"
                                        rows="3">{{ old('content', $video->content ?? '') }}</textarea>
                                    <div class="text-danger validation-err" id="content-err"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script>

        $(document).ready(function () {
            CKEDITOR.replace('content');
            setInterval(() => $(".cke_notifications_area").remove(), 100);

            function fetchCourses(subCategoryId, type, selectedCourse = null) {
                if (!subCategoryId) return;
                $.get(`{{ url('fetch-course') }}/${subCategoryId}`, { type: type }, function (result) {
                    if (result.success) {
                        $('#course').html(result.html);

                        // If we’re editing, select the saved course
                        if (selectedCourse) {
                            $('#course').val(selectedCourse).trigger('change');
                        }
                    }
                });
            }

            function fetchChapters(courseId, selectedSubject = null, selectedChapter = null, selectedTopic = null) {
                if (!courseId) return;
                $.get(`{{ url('fetch-chapter') }}/${courseId}`, { subject_id: selectedSubject, chapter_id: selectedChapter }, function (result) {
                    if (result.success) {
                        $('#subject_id').html(result.subject_html);
                        $('#chapter_id').html(result.chapter_html);
                        $('#topic_id').html(result.topic_html);

                        // ✅ Preselect stored values for edit
                        if (selectedSubject) $('#subject_id').val(selectedSubject);
                        if (selectedChapter) $('#chapter_id').val(selectedChapter);
                        if (selectedTopic) $('#topic_id').val(selectedTopic);
                    }
                });
            }


    function filterTeachers() {
        var examTypeId = $('#courseType').val();
        var categoryId = $('#courseCategory').val();
        var subCategoryId = $('#sub_category_id').val();
        var subjectId = $('#subject_id').val();

        if (!examTypeId && !categoryId && !subCategoryId && !subjectId) return;

        $.ajax({
            url: `{{ url('fetch-teachers-by-filters') }}`,
            type: "GET",
            data: {
                exam_type_id: examTypeId,
                category_id: categoryId,
                sub_category_id: subCategoryId,
                subject_id: subjectId
            },
            success: function (response) {
                if (response.success) {
                    $('.live-container select[name="teacher_id[]"]').each(function () {
                        $(this).html(response.html);
                    });
                }
            },
            error: function (xhr) {
                console.error('Error fetching teachers:', xhr.responseText);
            }
        });
    }



            // On page load: preselect dropdowns for edit
            const initialSubCategory = '{{ $video->sub_category_id ?? "" }}';
            const initialCourse = '{{ $video->course_id ?? "" }}';
            const initialSubject = '{{ $video->subject_id ?? "" }}';
            const initialChapter = '{{ $video->chapter_id ?? "" }}';
            const initialTopic = '{{ $video->topic_id ?? "" }}';
            const type = $('#type').val();

            if (initialSubCategory) {
                fetchCourses(initialSubCategory, type, initialCourse);

                // Once the course and subjects are fetched, chain fetchChapters()
                if (initialCourse) {
                    // Delay slightly to ensure the previous AJAX call populates properly
                    setTimeout(() => {
                        fetchChapters(initialCourse, initialSubject, initialChapter, initialTopic);
                    }, 500);
                }
            }

            // On sub-category change
            $('#sub_category_id').on('change', function () {
                const subCategoryId = $(this).val();
                fetchCourses(subCategoryId, $('#type').val());
                $('#chapter_id, #subject_id, #topic_id').html('');
            });

            // On course change
            $('#course').on('change', function () {
                const courseId = $(this).val();
                fetchChapters(courseId, initialSubject, initialChapter, initialTopic);
            });

            // On subject change
            $('#subject_id').on('change', function () {
                const courseId = $('#course').val();
                const subjectId = $(this).val();
                fetchChapters(courseId, subjectId, initialChapter, initialTopic);
            });

            // On chapter change
            $('#chapter_id').on('change', function () {
                const courseId = $('#course').val();
                const chapterId = $(this).val();
                const subjectId = $('#subject_id').val();
                fetchChapters(courseId, subjectId, chapterId, initialTopic);
            });

               $(document).on('change', '#courseType, #courseCategory, #sub_category_id, #subject_id', function () {
        if ($('#type').val() === 'live_class') {
            filterTeachers();
        }
    });
                 // ✅ Preselect video type and toggle visibility on edit
const existingVideoType = '{{ $video->video_type ?? "" }}';
if (existingVideoType) {
    const parent = $('.video-block');
    const type = existingVideoType;

    // Select the saved video type
    parent.find('.video_type').val(type);

    // Show proper input fields
    parent.find('.video_file_div, .video_url_div, .video_duration_div').hide();

    if (type === 'Storage') {
        parent.find('.video_file_div, .video_duration_div').show();
    } else if (['YouTube', 'Vimeo', 'Other'].includes(type)) {
        parent.find('.video_url_div, .video_duration_div').show();
    }
    
}
     
       // When Type changes (video / live_class)
$('#type').on('change', function () {
    const type = $(this).val();
    const subCategoryId = $('#sub_category_id').val();

    // Toggle visibility
    $('.video-container').toggle(type === 'video');
    $('.live-container').toggle(type === 'live_class');

    // Fetch course list again based on selected type
    if (subCategoryId) {
        fetchCourses(subCategoryId, type);
    } else {
        $('#course').html('<option value="">Select Course</option>');
    }

    // Also clear dependent fields
    $('#subject_id, #chapter_id, #topic_id').html('<option value="">--Select--</option>');
});

        // Video Type toggle
        $(document).on('change', '.video_type', function () {
            const type = $(this).val();
            const parent = $(this).closest('.video-block');
            parent.find('.video_file_div, .video_url_div, .video_duration_div').hide();

            if (type === 'Storage') parent.find('.video_file_div, .video_duration_div').show();
            else if (['YouTube', 'Vimeo', 'Other'].includes(type)) parent.find('.video_url_div, .video_duration_div').show();
        });

        // Fetch categories
        $('#courseType').on('change', function () {
            const data = $(this).val();
            $.get(`{{ url('fetch-category') }}/${data}`, function (result) {
                $('#courseCategory').html(result.html);
                $('#course, #chapter_id, #topic_id').html('');
            });
        });

        // Fetch sub-categories
        $('#courseCategory').on('change', function () {
            const data = $(this).val();
            $.get(`{{ url('fetch-sub-category-by-exam-category') }}/${data}`, function (result) {
                $('#sub_category_id').html(result.html);
                $('#course, #chapter_id, #topic_id').html('');
            });
        });


        // Title to slug
        $('#title').on('input', function () {
            $('#slug').val($(this).val().toLowerCase().replace(/\s+/g, '-'));
        });

        // Live image preview
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => $(previewId).attr('src', e.target.result).show();
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#image').on('change', () => previewImage($('#image')[0], '#live_thumb_preview'));
        $('#cover_image').on('change', () => previewImage($('#cover_image')[0], '#live_cover_preview'));
        $('#assignment').on('change', () => previewImage($('#assignment')[0], '#live_assignment_preview'));

        // Submit form via AJAX
        $('#categoryForm').submit(function (e) {
            e.preventDefault();
            for (instance in CKEDITOR.instances) CKEDITOR.instances[instance].updateElement();
            $(".validation-err").html('');

            $.ajax({
                type: 'POST',
                url: '{{ isset($video) && $video->id ? route("video.update", $video->id) : route("video.store") }}',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.success) window.location.href = '{{ route("video.index") }}';
                    else if (result.code === 422) {
                        for (const key in result.errors) $(`#${key}-err`).html(result.errors[key][0]);
                    }
                },
                error: function (err) {
                    console.error(err);
                    alert('Error saving topic. Please try again.');
                }
            });
        });

           });

    </script>

    <style>
        input[type="file"] {
            display: block;
            padding-bottom: 10px;
        }
    </style>
@endsection