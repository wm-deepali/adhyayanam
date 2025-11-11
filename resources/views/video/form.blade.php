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

                        <!-- Assignment Image -->
                        <div class="col-md-6 mb-2">
                            <label>Assignment Image (optional):</label>
                            <input type="file" class="form-control-file" name="video_assignment[]">
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
                            <textarea class="form-control" name="video_content[]" rows="3"></textarea>
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
                        <div class="col-md-6 mb-2">
                            <label for="live_title">Title:</label>
                            <input type="text" class="form-control" name="live_title[]"
                                placeholder="Enter Live Class Title">
                        </div>

                        <!-- Assignment Image -->
                        <div class="col-md-6 mb-2">
                            <label for="assignment">Assignment Image (optional):</label>
                            <input type="file" class="form-control-file" name="live_assignment[]">
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
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
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
                            <textarea class="form-control" name="live_content[]" rows="3"></textarea>
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
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');

    // Auto-generate slug per video title
    $(document).on("input", ".video_title", function () {
        var title = $(this).val().toLowerCase().replace(/\s+/g, '-');
        $(this).closest('.video-block').find('.video_slug').val(title);
    });


    setInterval(function () {
        $(document).find(".cke_notifications_area").remove();
    }, 100);

    // When type changes
    // When type changes
    $("#type").on("change", function () {
        var data = this.value;

        if (data == "video") {
            $(".video-container").show();
            $(".live-container").hide();
            $(".wa, .video_div").show(); // Show Access Till & No. of times
        } else if (data == "live_class") {
            $(".live-container").show();
            $(".video-container").hide();
            $(".wa, .video_div").hide(); // Hide Access Till & No. of times
            filterTeachers(); // Trigger teacher filtering
        } else {
            $(".video-container, .live-container").hide();
            $(".wa, .video_div").show();
        }

        fetchCoursesBySubCategory(); // refresh courses when type changes
    });

    // Add new video block
    $('#addVideo').on('click', function () {
        var newBlock = $('.video-block:first').clone(); // clone first block
        newBlock.find('input, textarea').val(''); // clear values
        newBlock.find('select').prop('selectedIndex', 0); // reset dropdowns
        newBlock.find('.video_file_div, .video_url_div, .video_duration_div').hide(); // hide conditional divs
        $('#videoWrapper').append(newBlock);
    });

    // Remove video block
    $(document).on('click', '.remove-video', function () {
        if ($('.video-block').length > 1) { // keep at least one block
            $(this).closest('.video-block').remove();
        } else {
            alert("At least one video is required.");
        }
    });


    // Add new Live Class block
    $('#addLive').on('click', function () {
        var newBlock = $('.live-block:first').clone(); // clone first block
        newBlock.find('input, textarea').val(''); // clear text fields
        newBlock.find('select').prop('selectedIndex', 0); // reset dropdowns
        $('#liveWrapper').append(newBlock);
    });

    // Remove Live Class block
    $(document).on('click', '.remove-live', function () {
        if ($('.live-block').length > 1) {
            $(this).closest('.live-block').remove();
        } else {
            alert("At least one live class is required.");
        }
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