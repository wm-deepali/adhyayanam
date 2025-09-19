@extends('layouts.app')

@section('title')
Edit | Course
@endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
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
            <form method="POST" action="{{ route('courses.course.update', $course->id) }}" id="course-form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="feature" class="form-label">Feature</label>
                            <input class="form-control" id="feature" name="feature" @if($course->feature == 'on') checked @endif type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="examination_commission_id" class="form-label">Course Type</label>
                            <select class="form-select" name="examination_commission_id" id="examination_commission_id" required>
                                <option value="" disabled>None</option>
                                @foreach($examinationCommissions as $commission)
                                    <option value="{{ $commission->id }}" {{ $commission->id == $course->examination_commission_id ? 'selected' : '' }}>{{ $commission->name }}</option>
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
                                <option value="{{$course->subCategory->id}}" selected>{{$course->subCategory->name}}</option>
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
                            <input type="text" class="form-control" name="name" placeholder="Course Name" value="{{ $course->name }}" required>
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
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" placeholder="Duration" value="{{ $course->duration }}" required>
                            @error('duration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_fee" class="form-label">Fee</label>
                            <input type="number" class="form-control" name="course_fee" placeholder="Fee" value="{{ $course->course_fee }}" required>
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
                            <input type="number" class="form-control" name="discount" placeholder="Discount" value="{{ $course->discount }}" required>
                            @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="offered_price" class="form-label">Offered Price</label>
                            <input type="number" class="form-control" name="offered_price" placeholder="Offered Price" value="{{ $course->offered_price }}" required>
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
                            <input type="number" class="form-control" name="num_classes" placeholder="Number Of Classes" value="{{ $course->num_classes }}" required>
                            @error('num_classes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="num_topics" class="form-label">Number Of Topics</label>
                            <input type="number" class="form-control" name="num_topics" placeholder="Number Of Topics" value="{{ $course->num_topics }}" required>
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
                                    <option value="{{$course->language_of_teaching[0]}}" selected>{{$course->language_of_teaching}}</option>
                            </select>
                            @error('language_of_teaching')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_heading" class="form-label">Heading*</label>
                            <input type="text" class="form-control" name="course_heading" placeholder="Heading" value="{{ $course->course_heading }}" required>
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
                            <input type="text" class="form-control" name="short_description" placeholder="Short Description" value="{{ $course->short_description }}" required>
                            @error('short_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="thumbnail_image" class="form-label">Upload Thumbnail</label>
                            <input type="file" 
                                class="form-control" 
                                name="thumbnail_image" 
                                id="thumbnail_image" accept="image/*">
                            <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="Thumbnail" width="100">
                            @if ($errors->has('thumbnail_image'))
                                <span class="text-danger text-left">{{ $errors->first('thumbnail_image') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="course_overview" class="form-label">Course Overview*</label>
                    <textarea id="course_overview" name="course_overview" style="height: 300px;">{{ $course->course_overview }}</textarea>
                    @error('course_overview')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="detail_content" class="form-label">Course Detail*</label>
                    <textarea id="detail_content" name="detail_content" style="height: 200px;">{{ $course->detail_content }}</textarea>
                    @error('detail_content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Upload Banner</label>
                            <input type="file" 
                                class="form-control" 
                                name="banner_image" 
                                id="banner_image" accept="image/*">
                            <img src="{{ asset('storage/' . $course->banner_image) }}" alt="Banner" width="100">
                            @if ($errors->has('banner_image'))
                                <span class="text-danger text-left">{{ $errors->first('banner_image') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">Youtube Video Url</label>
                            <input type="text" class="form-control" name="youtube_url" placeholder="Youtube Video Url" value="{{ $course->youtube_url }}" required>
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
                            <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="{{ $course->meta_title }}" required>
                            @error('meta_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_keyword" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keyword" placeholder="Tag, Tag" value="{{ $course->meta_keyword }}" required>
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
                            <input type="text" class="form-control" name="meta_description" placeholder="Meta Description" value="{{ $course->meta_description }}" required>
                            @error('meta_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image_alt_tag" class="form-label">Alt Tag</label>
                            <input type="text" class="form-control" name="image_alt_tag" placeholder="Tag" value="{{ $course->image_alt_tag }}" required>
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script>
    $('.select2').select2({
        data: ["English", "Hindi"],
        tags: true,
        maximumSelectionLength: 5,
        tokenSeparators: [',', ' '],
        placeholder: "Select Languages",
    });
</script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
         CKEDITOR.replace('detail_content');
         CKEDITOR.replace('course_overview');
        setInterval(function() {
                $(document).find(".cke_notifications_area").remove();
            }, 100);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const examinationCommissionSelect = document.getElementById('examination_commission_id');
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');

    examinationCommissionSelect.addEventListener('change', function() {
        const examinationCommissionId = this.value;
        if (examinationCommissionId) {
            fetchCategories(examinationCommissionId);
        }
    });

    categorySelect.addEventListener('change', function() {
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
            success: function(response) {
                categorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                response.categories.forEach(category => {
                    categorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function fetchSubCategories(categoryId) {
        $.ajax({
            url: `{{ route('settings.subcategories', '') }}/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                subCategorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                response.subcategories.forEach(subcategory => {
                    subCategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                });
            },
            error: function(error) {
                console.error('Error fetching subcategories:', error);
            }
        });
    }
});
</script>
@endsection
