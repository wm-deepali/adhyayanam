@extends('layouts.app')

@section('title')
    Create | Course
@endsection
@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Create</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Add Course here.</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('courses.course.store') }}" id="course-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            
                            <div class="mb-3">
                                <label for="feature" class="form-label">Feature</label>
                                <input class="form-control" id="feature" name="feature" type="checkbox" data-toggle="toggle"
                                    data-onstyle="success" data-offstyle="danger" data-width="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_mode" class="form-label">Course Mode</label>
                                <select class="form-control" name="course_mode" id="course_mode" required>
                                    <option value="" selected disabled>None</option>
                                    <option value="Online">Online</option>
                                    <option value="Video Learning">Video Learning</option>
                                </select>
                                @error('course_mode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="examination_commission_id" class="form-label">Course Type</label>
                                <select class="form-control" name="examination_commission_id" id="examination_commission_id"
                                    required>
                                    <option value="" selected disabled>None</option>
                                    @foreach($examinationCommissions as $commission)
                                        <option value="{{ $commission->id }}">{{ $commission->name }}</option>
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
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="" selected disabled>None</option>
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
                                <select class="form-control" name="sub_category_id" id="sub_category_id">
                                    <option value="" selected disabled>None</option>
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
                                <input type="text" class="form-control" name="name" placeholder="Course Name" required>
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
                                    <option value="">--Select--</option>
                                    <!-- Populated dynamically -->
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
                                    <option value="">--Select--</option>
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
                                    <option value="">--Select--</option>
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
                                <input type="text" class="form-control" name="duration" placeholder="Duration" required>
                                @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_fee" class="form-label">Fee</label>
                                <input type="number" class="form-control" id="course_fee" name="course_fee"
                                    placeholder="Fee" required>
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
                                <input type="number" class="form-control" id="discount" name="discount"
                                    placeholder="Discount" required>
                                @error('discount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="offered_price" class="form-label">Offered Price</label>
                                <input type="number" class="form-control" id="offered_price" name="offered_price"
                                    placeholder="Offered Price" required readonly>
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
                                    required>
                                @error('num_classes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="num_topics" class="form-label">Number Of Topics</label>
                                <input type="number" class="form-control" name="num_topics" placeholder="Number Of Topics"
                                    required>
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
                                <select class="form-control select2" name="language_of_teaching[]" multiple>
                                    <option value="English">English</option>
                                    <option value="Hindi">Hindi</option>
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
                                    required>
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
                                    placeholder="Short Description" required>
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

                                @if ($errors->has('thumbnail_image'))
                                    <span class="text-danger text-left">{{ $errors->first('thumbnail_image') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="course_overview" class="form-label">Course Overview*</label>
                        <textarea id="course_overview" name="course_overview" style="height: 300px;"></textarea>
                        @error('course_overview')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="detail_content" class="form-label">Course Detail*</label>
                        <textarea id="detail_content" name="detail_content" style="height: 200px;"></textarea>
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

                                @if ($errors->has('banner_image'))
                                    <span class="text-danger text-left">{{ $errors->first('banner_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="youtube_url" class="form-label">Youtube Video Url</label>
                                <input type="text" class="form-control" name="youtube_url" placeholder="Youtube Video Url"
                                    required>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" required>
                                @error('meta_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_keyword" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Tag, Tag" required>
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
                                    placeholder="Meta Description" required>
                                @error('meta_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_alt_tag" class="form-label">Alt Tag</label>
                                <input type="text" class="form-control" name="image_alt_tag" placeholder="Tag" required>
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

   <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>

        $(document).ready(function () {

            function calculateOfferedPrice() {
                let courseFee = parseFloat($('#course_fee').val()) || 0;
                let discount = parseFloat($('#discount').val()) || 0;

                // Prevent negative price
                let offeredPrice = courseFee - discount;
                if (offeredPrice < 0) offeredPrice = 0;
                if (discount > courseFee) {
                    discount = courseFee;
                    $('#discount').val(courseFee);
                }
                $('#offered_price').val(offeredPrice);

            }

            // Recalculate on input
            $('#course_fee, #discount').on('input', function () {
                calculateOfferedPrice();
            });

CKEDITOR.replace('detail_content', {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
    filebrowserUploadMethod: 'form'
});

CKEDITOR.replace('course_overview', {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
    filebrowserUploadMethod: 'form'
});

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