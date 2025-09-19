<style>
    input[type="file"] {
	display: block;
	padding-bottom: 10px;
}
</style>

<form id="categoryForm" enctype="multipart/form-data">
        @csrf
        @if(isset($topic) && $topic->id)  @method('PUT') @endif
         <div class="row mx-1">
            <div class="col-md-6">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type">
            <option value="" >Select Type</option>
            <option value="video" @if($topic->type == "video") selected @endif >Video</option>
            <option value="live_class" @if($topic->type == "live_class") selected @endif >Live Class</option>
        </select>
        <div class="text-danger validation-err" id="type-err"></div>
    </div>
            <div class="col-md-6">
                <label for="courseType">Examination Commission:</label>
                <select class="form-control" name="course_type" id="courseType">
                      <option value="">Select Examination Commission</option>
                    @foreach(\App\Models\ExaminationCommission::all() as $commission)
                            <option {{ $topic->course_type == $commission->id ? 'selected' : '' }}  value="{{ $commission->id }}">{{ $commission->name }}</option>
                        @endforeach
                </select>
                <div class="text-danger validation-err" id="course_type-err"></div>
            </div>
            <div class="col-md-6">
                <label for="courseCategory">Select Course Category:</label>
                <select class="form-control" name="course_category" id="courseCategory">
                    <option value="">Select Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $topic->course_category == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                </select>
                <div class="text-danger validation-err" id="course_category-err"></div>
            </div>
            <div class="col-md-6">
                <label for="courseCategory">Select Course:</label>
                <select class="form-control" name="course" id="course">
                    <option value="">Select Course</option>
                  @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $topic->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
                </select>
                <div class="text-danger validation-err" id="course-err"></div>
            </div>
            <div class="col-md-6">
                <label for="courseCategory">Select Chapter:</label>
                <select class="form-control" name="chapter" id="chapter">
                    <option value="">Select Chapter</option>
                  @foreach($chapters as $chapters)
                    <option value="{{ $chapters->id }}" {{ $topic->chapter_id == $chapters->id ? 'selected' : '' }}>
                        {{ $chapters->name }}
                    </option>
                @endforeach
                </select>
                <div class="text-danger validation-err" id="chapter-err"></div>
            </div>
            <div class="col-md-6">
            <label for="name">Title</label>
            <input type="text" class="form-control" id="title"  name="title" value="{{ old('title', $topic->title ?? '') }}" >
             <div class="text-danger validation-err" id="title-err"></div>
        </div>
         <div class="col-md-6">
            <label for="image">Thumb Image:</label>
            @if(isset($topic) && $topic->image)
                <img src="{{ asset('storage/' . $topic->image) }}" alt=" Image" style="max-width: 200px; margin-bottom: 10px;">
                @else
                <img src="#" alt=" Image" style="max-width: 200px; margin-bottom: 10px;display:none">
            @endif
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
             <div class="text-danger validation-err" id="image-err"></div>
        </div>
        <div class="col-md-6">
            <label for="image">Cover Image:</label>
            @if(isset($topic) && $topic->image)
                <img src="{{ asset('storage/' . $topic->cover_image) }}" alt=" Image" style="max-width: 200px; margin-bottom: 10px;">
                @else
                <img src="#" alt=" Image" style="max-width: 200px; margin-bottom: 10px;display:none">
            @endif
            <input type="file" class="form-control-file" id="cover_image" name="cover_image" accept="image/*">
             <div class="text-danger validation-err" id="cover_image-err"></div>
        </div>
        <div class="col-md-6 video_div " @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="asignment" name="asignment" value="yes" @if($topic->asignment == "yes") checked @endif >
                <label class="custom-control-label" for="asignment">Assignment</label>
            </div>
            </div>
        <div class="col-md-6">
            <label for="image">Assignment Image:</label>
            @if(isset($topic) && $topic->assignment)
                <img src="{{ asset('storage/' . $topic->assignment) }}" alt="assignment Image" style="max-width: 200px; margin-bottom: 10px;">
                @else
                <img src="#" alt="assignment Image" style="max-width: 200px; margin-bottom: 10px;display:none">
            @endif
            <input type="file" class="form-control-file" id="assignment" name="assignment" >
             <div class="text-danger validation-err" id="assignment-err"></div>
        </div>
        <div class="col-md-6">
            <label for="slug">Slug:</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $topic->slug ?? '') }}" >
             <div class="text-danger validation-err" id="slug-err"></div>
        </div> 
        <div class="col-md-6 video_div" @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif>
                <label for="courseType">Select Video Type:</label>
                <select class="form-control" name="video_type" id="video_type">
                      <option value="">Select Video Type</option>
                    <option @if($topic->video_type == "YouTube") selected @endif value="YouTube">YouTube</option>
                    <option @if($topic->video_type == "Vimeo") selected @endif value="Vimeo">Vimeo</option>
                    <option @if($topic->video_type == "Storage") selected @endif value="Storage">Storage</option>
                    <option @if($topic->video_type == "Other") selected @endif value="Other">Other</option>
                </select>
                <div class="text-danger validation-err" id="video_type-err"></div>
            </div>
            <div class="col-md-6 video_div video_file" style="display:none" >
            <label for="slug">Video File:</label>
            <input type="file" class="form-control" id="video_file" name="video_file" value="{{ old('video_url', $topic->video_url ?? '') }}" >
             <div class="text-danger validation-err" id="video_file-err"></div>
            </div>
            <div class="col-md-6 video_div video_url" @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <label for="slug">Video URL:</label>
            <input type="text" class="form-control" id="video_url" name="video_url" value="{{ old('video_url', $topic->video_url ?? '') }}" >
             <div class="text-danger validation-err" id="video_url-err"></div>
            </div>
            <div class="col-md-6 video_div " @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <label for="slug">Duration:</label>
            <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration', $topic->duration ?? '') }}" >
             <div class="text-danger validation-err" id="duration-err"></div>
            </div>
            <div class="col-md-6 video_div " @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <label for="slug">Access Till:</label>
            <input type="date" class="form-control" id="access_till" name="access_till" value="{{ old('access_till', $topic->access_till ?? '') }}" >
             <div class="text-danger validation-err" id="access_till-err"></div>
            </div>
            <div class="col-md-6 video_div " @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <label for="slug">No. Of times can view:</label>
            <input type="number" class="form-control" id="no_of_times_can_view" name="no_of_times_can_view" value="{{ old('no_of_times_can_view', $topic->no_of_times_can_view ?? '') }}" >
             <div class="text-danger validation-err" id="no_of_times_can_view-err"></div>
            </div>
             <div class="col-md-6 video_div " @if($topic->type != "" && $topic->type == "live_class") style="display:none" @endif >
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="support" name="support" value="yes" @if($topic->support == "yes") checked @endif >
                <label class="custom-control-label" for="support">Support</label>
            </div>
            </div>
            
        
        <div class="col-md-6 live_class_div" @if($topic->type != "" && $topic->type == "video") style="display:none" @endif >
            <label for="schedule_date">Schedule Date:</label>
            <input type="date" class="form-control" id="schedule_date" name="schedule_date" value="{{ old('schedule_date', $topic->schedule_date ?? '') }}" >
             <div class="text-danger validation-err" id="schedule_date-err"></div>
        </div>
        <div class="col-md-6 live_class_div" @if($topic->type != "" && $topic->type == "video") style="display:none" @endif >
            <label for="schedule_date">Start Time:</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $topic->start_time ?? '') }}" >
             <div class="text-danger validation-err" id="start_time-err"></div>
        </div>
        <div class="col-md-6 live_class_div" @if($topic->type != "" && $topic->type == "video") style="display:none" @endif>
            <label for="schedule_date">End Time:</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $topic->end_time ?? '') }}" >
             <div class="text-danger validation-err" id="end_time-err"></div>
        </div>
         <div class="col-md-6 live_class_div" @if($topic->type != "" && $topic->type == "video") style="display:none" @endif>
                <label for="courseCategory">Select Teacher:</label>
                <select class="form-control" name="teacher" id="teacher">
                    <option value="">Select Teacher</option>
                  @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $topic->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
                </select>
                <div class="text-danger validation-err" id="teacher-err"></div>
            </div>
        <div class="col-md-6">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" >
                <option value="active" {{ isset($topic) && $topic->status == "active" ? 'selected' : '' }}>Active</option>
                <option value="block" {{ isset($topic) && $topic->status == "block" ? 'selected' : '' }}>Inactive</option>
            </select>
             <div class="text-danger validation-err" id="status-err"></div>
        </div>
        <div class="col-md-12">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3">{{ old('content', $topic->content ?? '') }}</textarea>
            <div class="text-danger validation-err" id="content-err"></div>
        </div>
        </div>
        

        

       

        


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
 CKEDITOR.replace('content');
 
 setInterval(function() {
        $(document).find(".cke_notifications_area").remove();
    }, 100);
 
 $("#video_type").on("change",function(){
      var data = this.value;
      if(data == "Storage"){
          $(".video_file").removeAttr("style");
          $(".video_url").css("display","none");
      }else{
         $(".video_url").removeAttr("style");
          $(".video_file").css("display","none"); 
      }
 })
 $("#type").on("change",function(){
      var data = this.value;
      if(data == "video"){
          $(".video_div").removeAttr("style");
          $(".live_class_div").css("display","none");
      }else{
         $(".live_class_div").removeAttr("style");
          $(".video_div").css("display","none"); 
      }
 })
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
                $("#course").html('');
                $.ajax({
                    url: `{{url('fetch-course/${data}')}}`,
                    type: "GET",
                    success: function (result) {
                        $('#course').html(result.html);
                        $("#chapter").html('');
                    }
                });
            });
            $('#course').on('change', function () {
                var data = this.value;
                $("#chapter").html('');
                $.ajax({
                    url: `{{url('fetch-chapter/${data}')}}`,
                    type: "GET",
                    success: function (result) {
                        $('#chapter').html(result.html);
                    }
                });
            });
            $('#schedule_date').on('change', function () {
                var data = this.value;
                $("#teacher").html('');
                $.ajax({
                    url: `{{url('fetch-teacher')}}`,
                    type: "POST",
                    data:{"id":5,"_token":"{{csrf_token()}}"},
                    success: function (result) {
                        $('#teacher').html(result.html);
                    }
                });
            });
            
    $(document).on("input","#title",function(){
        var title = $(this).val().toLowerCase().replace(/\s+/g, '-');
        $("#slug").val(title)
    })
        
    
    $(document).ready(function() {
        
        // Image preview on file input change
        $('#image').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image').siblings('img').attr('src', e.target.result).css('max-width', '200px').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        $('#cover_image').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#cover_image').siblings('img').attr('src', e.target.result).css('max-width', '200px').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Form submission via AJAX
        $('#categoryForm').submit(function(e) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            e.preventDefault();
$(".validation-err").html('');
            $.ajax({
                type: 'POST',
                url: '{{ (isset($topic) && $topic->id) ? route("video.update", $topic->id) : route("video.store") }}',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(result) {
                   if (result.success) {
					        window.location.href = '{{ route("video.index") }}';
					} else {
						$(this).attr('disabled',false);
						if (result.code == 422) {
							for (const key in result.errors) {
								$(`#${key}-err`).html(result.errors[key][0]);
							}
						} else {
							
						}
					}
                    
                },
                error: function(error) {
                    console.error('Error saving topic:', error);
                    alert('Error saving topic. Please try again.');
                }
            });
        });
    });
</script>