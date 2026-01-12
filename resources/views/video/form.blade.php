<style>
    input[type="file"] {
        display: block;
        padding-bottom: 10px;
    }
</style>

<form id="categoryForm" enctype="multipart/form-data">
    @csrf
    <div class="row mx-1">
        <div class="col-md-6 mb-2">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="">Select Type</option>
                <option value="video">Video</option>
                <option value="live_class">Live Class</option>
            </select>
            <div class="text-danger validation-err" id="type-err"></div>
        </div>
        <div class="col-md-6 mb-2">
            <label for="courseType">Examination Commission:</label>
            <select class="form-control" name="course_type" id="courseType">
                <option value="">Select Examination Commission</option>
                @foreach(\App\Models\ExaminationCommission::all() as $commission)
                    <option value="{{ $commission->id }}">
                        {{ $commission->name }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger validation-err" id="course_type-err"></div>
        </div>
        <div class="col-md-6 mb-2">
            <label for="courseCategory">Select Course Category:</label>
            <select class="form-control" name="course_category" id="courseCategory">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger validation-err" id="course_category-err"></div>
        </div>
        <div class="col-md-6 mb-2">
            <label for="sub_category_id" class="form-label">Select Sub Category</label>
            <select class="form-select" name="sub_category_id" id="sub_category_id">
                <option value="" selected disabled>None</option>
                <!-- Options will be dynamically loaded -->
            </select>
            @error('sub_category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-2">
            <label for="courseCategory">Select Course:</label>
            <select class="form-control" name="course" id="course">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            <div class="text-danger validation-err" id="course-err"></div>
        </div>
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

        <div class="col-md-6 mb-2 wa ">
            <label for="slug">Access Till:</label>
            <input type="date" class="form-control" id="access_till" name="access_till">
            <div class="text-danger validation-err" id="access_till-err"></div>
        </div>
        <div class="col-md-6 mb-2 video_div">
            <label for="slug">No. Of times can view:</label>
            <input type="number" class="form-control" id="no_of_times_can_view" name="no_of_times_can_view">
            <div class="text-danger validation-err" id="no_of_times_can_view-err"></div>
        </div>
        <!-- VIDEO CONTAINER -->
        <div class="video-container" style="display:none;">
            <h5>Video Details</h5>

            <div id="videoWrapper">
                <div class="video-block border p-3 mb-3">
                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-6 mb-2">
                            <label>Title</label>
                            <input type="text" class="form-control video_title" name="video_title[]"
                                placeholder="Enter video title">
                        </div>

                        <!-- Slug -->
                        <div class="col-md-6 mb-2">
                            <label>Slug</label>
                            <input type="text" class="form-control video_slug" name="video_slug[]"
                                placeholder="Auto generated slug">
                        </div>


                        <!-- Thumb Image -->
                        <div class="col-md-6 mb-2">
                            <label>Thumb Image:</label>
                            <input type="file" class="form-control-file" name="video_image[]">
                        </div>

                        <!-- Cover Image -->
                        <div class="col-md-6 mb-2">
                            <label>Cover Image:</label>
                            <input type="file" class="form-control-file" name="video_cover_image[]">
                        </div>

                        <!-- Assignment File -->
                        <div class="col-md-6 mb-2">
                            <label>Upload Assignment (PDF/Image):</label>
                            <input type="file" class="form-control-file" name="video_assignment_file[]"
                                accept=".pdf,.doc,.docx,image/*">
                        </div>

                        <!-- Solution File -->
                        <div class="col-md-6 mb-2">
                            <label>Upload Solution (PDF/Image):</label>
                            <input type="file" class="form-control-file" name="video_solution_file[]"
                                accept=".pdf,.doc,.docx,image/*">
                        </div>

                        <!-- Video Type -->
                        <div class="col-md-6 mb-2">
                            <label>Video Type:</label>
                            <select class="form-control video_type" name="video_type[]">
                                <option value="">Select Video Type</option>
                                <option value="YouTube">YouTube</option>
                                <option value="Vimeo">Vimeo</option>
                                <option value="Storage">Storage</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Video File -->
                        <div class="col-md-6 mb-2 video_file_div" style="display:none">
                            <label>Video File:</label>
                            <input type="file" class="form-control" name="video_file[]">
                        </div>

                        <!-- Video URL -->
                        <div class="col-md-6 mb-2 video_url_div" style="display:none">
                            <label>Video URL:</label>
                            <input type="text" class="form-control" name="video_url[]">
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6 mb-2 video_duration_div" style="display:none">
                            <label>Duration:</label>
                            <input type="text" class="form-control" name="duration[]">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-2">
                            <label>Status:</label>
                            <select class="form-control" name="video_status[]">
                                <option value="active">Active</option>
                                <option value="block">Inactive</option>
                            </select>
                        </div>

                        <!-- Content -->
                        <div class="col-md-12 mb-2">
                            <label>Content</label>
                            <textarea class="form-control editor" name="video_content[]" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger remove-video">Remove</button>
                        </div>

                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary mt-2 mb-2" id="addVideo">Add More Video</button>
        </div>

        <!-- LIVE CLASS CONTAINER -->
        <div class="live-container" style="display:none;">
            <h5>Live Class Details</h5>

            <div id="liveWrapper">
                <div class="live-block border p-3 mb-3">
                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-12 mb-2">
                            <label for="live_title">Title:</label>
                            <input type="text" class="form-control" name="live_title[]"
                                placeholder="Enter Live Class Title">
                        </div>

                        <!-- Thumb Image -->
                        <div class="col-md-6 mb-2">
                            <label>Thumb Image:</label>
                            <input type="file" class="form-control-file" name="live_image[]">
                        </div>

                        <!-- Cover Image -->
                        <div class="col-md-6 mb-2">
                            <label>Cover Image:</label>
                            <input type="file" class="form-control-file" name="live_cover_image[]">
                        </div>

                        <!-- Assignment File -->
                        <div class="col-md-6 mb-2">
                            <label>Upload Assignment (PDF/Image):</label>
                            <input type="file" class="form-control-file" name="live_assignment_file[]"
                                accept=".pdf,.doc,.docx,image/*">
                        </div>

                        <!-- Solution File -->
                        <div class="col-md-6 mb-2">
                            <label>Upload Solution (PDF/Image):</label>
                            <input type="file" class="form-control-file" name="live_solution_file[]"
                                accept=".pdf,.doc,.docx,image/*">
                        </div>

                        <!-- Schedule Date -->
                        <div class="col-md-6 mb-2">
                            <label for="schedule_date">Schedule Date:</label>
                            <input type="date" class="form-control" name="schedule_date[]">
                        </div>

                        <!-- Start Time -->
                        <div class="col-md-6 mb-2">
                            <label for="start_time">Start Time:</label>
                            <input type="time" class="form-control" name="start_time[]">
                        </div>

                        <!-- End Time -->
                        <div class="col-md-6 mb-2">
                            <label for="end_time">End Time:</label>
                            <input type="time" class="form-control" name="end_time[]">
                        </div>

                        <!-- Teacher -->
                        <div class="col-md-6 mb-2">
                            <label for="teacher">Select Teacher:</label>
                            <select class="form-control" name="teacher_id[]">
                                <option value="">Select Teacher</option>
                                @foreach(\App\Models\Teacher::all() as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Live Class Link -->
                        <div class="col-md-6 mb-2">
                            <label for="live_link">Live Class Link (URL):</label>
                            <input type="url" class="form-control" name="live_link[]"
                                placeholder="Enter live class URL">
                        </div>


                        <!-- Status -->
                        <div class="col-md-6 mb-2">
                            <label for="status">Status:</label>
                            <select class="form-control" name="live_status[]">
                                <option value="active">Active</option>
                                <option value="block">Inactive</option>
                            </select>
                        </div>

                        <!-- Content -->
                        <div class="col-md-12 mb-2">
                            <label for="content">Content</label>
                            <textarea class="form-control editor" name="live_content[]" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger remove-live">Remove</button>
                        </div>

                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary mt-2 mb-2" id="addLive">Add More Live Class</button>
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script>


    /* ================= CKEDITOR SAFE HANDLING ================= */

    function initEditors() {
        $('.editor').each(function () {
            if (!this.id) {
                this.id = 'editor_' + Math.random().toString(36).substr(2, 9);
            }
            if (!CKEDITOR.instances[this.id]) {
                   CKEDITOR.replace(this.id, {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
    filebrowserUploadMethod: 'form'
});
            }
        });
    }

    $(document).ready(function () {
        initEditors();
    });

    /* ================= CLONE CLEAN BLOCK ================= */

    function cloneClean(selector) {
        return $($(selector).prop('outerHTML'));
    }

    $('#addVideo').on('click', function () {
        const block = cloneClean('.video-block:first');
        block.find('input, textarea').val('');
        block.find('textarea').removeAttr('id');
        $('#videoWrapper').append(block);
        initEditors();
    });

    $('#addLive').on('click', function () {
        const block = cloneClean('.live-block:first');
        block.find('input, textarea').val('');
        block.find('textarea').removeAttr('id');
        $('#liveWrapper').append(block);
        initEditors();
    });

    /* ================= REMOVE ================= */
    $(document).on('click', '.remove-video', function () {
        if ($('.video-block').length > 1) {
            $(this).closest('.video-block').find('.editor').each(function () {
                if (this.id && CKEDITOR.instances[this.id]) {
                    CKEDITOR.instances[this.id].destroy(true);
                }
            });
            $(this).closest('.video-block').remove();
        }
    });

    $(document).on('click', '.remove-live', function () {
        if ($('.live-block').length > 1) {
            $(this).closest('.live-block').find('.editor').each(function () {
                if (this.id && CKEDITOR.instances[this.id]) {
                    CKEDITOR.instances[this.id].destroy(true);
                }
            });
            $(this).closest('.live-block').remove();
        }
    });



    /* ================= TYPE TOGGLE ================= */

    $('#type').on('change', function () {
        const type = $(this).val();

        $('.video-container').toggle(type === 'video');
        $('.live-container').toggle(type === 'live_class');

        $('.wa, .video_div').toggle(type === 'video');
    });


    /* ================= SLUG ================= */

    $(document).on('input', '.video_title', function () {
        const slug = $(this).val().toLowerCase().replace(/[^\w ]+/g, '').replace(/\s+/g, '-');
        $(this).closest('.video-block').find('.video_slug').val(slug);
    });


    // Show/hide file or URL based on video type
    $(document).on('change', '.video_type', function () {
        var type = $(this).val();
        var parent = $(this).closest('.video-block');

        if (type == "Storage") {
            parent.find('.video_file_div').show();
            parent.find('.video_url_div').hide();
            parent.find('.video_duration_div').show();
        } else if (type == "YouTube" || type == "Vimeo" || type == "Other") {
            parent.find('.video_url_div').show();
            parent.find('.video_file_div').hide();
            parent.find('.video_duration_div').show();
        } else {
            parent.find('.video_file_div, .video_url_div, .video_duration_div').hide();
        }
    });
    $('#courseType').on('change', function () {
        var data = this.value;
        $("#courseCategory").html('');
        $.ajax({
            url: `{{url('fetch-category/${data}')}}`,
            type: "GET",
            success: function (result) {
                $('#courseCategory').html(result.html);
                $("#course").html('');
                $("#chapter").html('');
            }
        });
    });
    $('#courseCategory').on('change', function () {
        var data = this.value;
        $("#sub_category_id").html('');
        $.ajax({
            url: `{{url('fetch-sub-category-by-exam-category/${data}')}}`,
            type: "GET",
            success: function (result) {
                $('#sub_category_id').html(result.html);
                $("#course").html('');
                $("#chapter").html('');
            }
        });
    });

    function fetchCoursesBySubCategory() {
        var subCategoryId = $('#sub_category_id').val();
        var selectedType = $('#type').val();

        if (!subCategoryId) return; // do nothing if no sub-category selected

        $("#course").html(''); // clear previous options

        $.ajax({
            url: `{{ url('fetch-course') }}/${subCategoryId}`,
            type: "GET",
            data: { type: selectedType }, // send type along
            success: function (result) {
                $('#course').html(result.html);
                $("#chapter").html(''); // clear dependent dropdowns
                $("#topic_id").html('');
            },
            error: function (err) {
                console.error(err);
            }
        });
    }

    // When sub-category changes
    $(document).on('change', '#sub_category_id', function (e) {
        e.preventDefault();
        fetchCoursesBySubCategory();
    });


    // When course changes (already done)
    $('#course').on('change', function () {
        var courseId = this.value;

        // Clear all selects first
        $("#subject_id").html('');
        $("#chapter_id").html('');
        $("#topic_id").html('');

        $.ajax({
            url: `{{ url('fetch-chapter/${courseId}') }}`,
            type: "GET",
            success: function (result) {
                if (result.success) {
                    $('#subject_id').html(result.subject_html);
                    $('#chapter_id').html(result.chapter_html);
                    $('#topic_id').html(result.topic_html);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // When subject changes -> filter chapters and topics
    $('#subject_id').on('change', function () {
        var courseId = $('#course').val();
        var subjectId = $(this).val();

        $.ajax({
            url: `{{ url('fetch-chapter/${courseId}') }}`,
            type: "GET",
            data: { subject_id: subjectId },
            success: function (result) {
                if (result.success) {
                    $('#chapter_id').html(result.chapter_html);
                    $('#topic_id').html(result.topic_html);
                }
            }
        });
    });

    // When chapter changes -> filter topics
    $('#chapter_id').on('change', function () {
        var courseId = $('#course').val();
        var chapterId = $(this).val();

        $.ajax({
            url: `{{ url('fetch-chapter/${courseId}') }}`,
            type: "GET",
            data: { chapter_id: chapterId },
            success: function (result) {
                if (result.success) {
                    $('#topic_id').html(result.topic_html);
                }
            }
        });
    });


    $('#schedule_date').on('change', function () {
        var data = this.value;
        $("#teacher").html('');
        $.ajax({
            url: `{{url('fetch-teacher')}}`,
            type: "POST",
            data: { "id": 5, "_token": "{{csrf_token()}}" },
            success: function (result) {
                $('#teacher').html(result.html);
            }
        });
    });

    $(document).on("input", "#title", function () {
        var title = $(this).val().toLowerCase().replace(/\s+/g, '-');
        $("#slug").val(title)
    })


    $(document).ready(function () {

        // Image preview on file input change
        $('#image').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image').siblings('img').attr('src', e.target.result).css('max-width', '200px').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        $('#cover_image').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cover_image').siblings('img').attr('src', e.target.result).css('max-width', '200px').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Form submission via AJAX
        $('#categoryForm').submit(function (e) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            e.preventDefault();
            $(".validation-err").html('');
            $.ajax({
                type: 'POST',
                url: '{{ route("video.store") }}',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.success) {
                        window.location.href = '{{ route("video.index") }}';
                    } else {
                        $(this).attr('disabled', false);
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {

                        }
                    }

                },
                error: function (error) {
                    console.error('Error saving topic:', error);
                    alert('Error saving topic. Please try again.');
                }
            });
        });
    });

    $(document).on('change', '#courseType, #courseCategory, #sub_category_id, #subject_id', function () {
        if ($('#type').val() === 'live_class') {
            filterTeachers();
        }
    });


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


</script>