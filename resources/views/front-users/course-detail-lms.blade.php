@extends('front-users.layouts.app')

@section('title')
    {{ $course->course_heading }} - Course
@endsection
<style>
    .video-wrapper{
position:relative;
}

.fullscreen-btn{
position:absolute;
top:10px;
right:10px;
z-index:10;
background:#000;
color:#fff;
border:none;
padding:6px 12px;
border-radius:5px;
font-size:13px;
opacity:0.8;
}

.fullscreen-btn:hover{
opacity:1;
}


.course-video-card{
border-radius:10px;
overflow:hidden;
}

.lesson-list{
max-height:500px;
overflow-y:auto;
}

.lesson-item{
display:flex;
justify-content:space-between;
align-items:center;
padding:12px;
border-bottom:1px solid #eee;
cursor:pointer;
transition:0.2s;
}

.lesson-item:hover{
background:#f6f9ff;
}

.lesson-item.active{
background:#eef4ff;
border-left:4px solid #0d6efd;
}

.lesson-left{
display:flex;
align-items:center;
gap:10px;
}

.lesson-icon{
width:28px;
height:28px;
background:#0d6efd;
color:#fff;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
font-size:12px;
}

.lesson-title{
font-size:14px;
font-weight:500;
}


</style>

@section('content')
    <section class="content">
        <div class="container">

            {{-- ================= COURSE HEADER ================= --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-1">{{ $course->course_heading }} </h4>
                    <p class="text-muted mb-0">{{ $course->short_description }}</p>
                </div>
            </div>

            <div class="row">
                {{-- ================= MAIN CONTENT ================= --}}
                <div class="col-md-8">

                    {{-- VIDEO PLAYER --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-body p-2">
                            <!--<div id="mainVideoContainer" class="text-center">-->
                            <!--    <div class="text-muted py-5">-->
                            <!--        Select a video from the right to start learning-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <div class="video-wrapper">

<button id="fullscreenBtn" class="fullscreen-btn">
⛶ Fullscreen
</button>

<div id="mainVideoContainer" class="text-center d-flex align-items-center">
    <div class="text-muted py-5">
        Select a video from the right to start learning
    </div>
</div>

</div>

                        </div>
                    </div>

                    <h5 class="fw-semibold mb-3" id="mainVideoTitle"></h5>

                    {{-- ASSIGNMENT --}}
                    <div id="assignmentContainer"></div>

                    {{-- COURSE DETAIL --}}
                    {{-- COURSE DETAIL --}}
                    <div class="card mt-3">
                        <div class="card-body">
                            {!! $course->detail_content !!}
                        </div>
                    </div>

                    {{-- ================= COURSE REVIEWS ================= --}}
                    <div class="card mt-3">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">⭐ Course Reviews</h5>

                            {{-- REVIEW FORM --}}
                            <form action="{{ route('student.course.review') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">

                                <div class="mb-2">
                                    <label class="form-label">Rating</label>

                                    <select name="rating" class="form-control" required>
                                        <option value="">Select Rating</option>

                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" {{ ($review && $review->rating == $i) ? 'selected' : '' }}>
                                                {{ str_repeat('⭐', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Review</label>

                                    <textarea name="review" class="form-control" rows="3"
                                        placeholder="Write your feedback">{{ $review->review ?? '' }}</textarea>
                                </div>

                                <button class="btn btn-primary btn-sm">
                                    {{ $review ? 'Update Review' : 'Submit Review' }}
                                </button>

                            </form>

                            {{-- SHOW OTHER STUDENT REVIEWS --}}
                            @if($course->reviews->count())

                                <hr>

                                @foreach($course->reviews as $r)

                                    <div class="border-bottom mb-3 pb-2">

                                        <div class="d-flex justify-content-between">

                                            <strong>{{ $r->student->full_name ?? 'Student' }}</strong>

                                            <div>
                                                {{ str_repeat('⭐', $r->rating) }}
                                            </div>

                                        </div>

                                        <small class="text-muted">
                                            {{ $r->created_at->format('d M Y') }}
                                        </small>

                                        <p class="mb-0 mt-1">
                                            {{ $r->review }}
                                        </p>

                                    </div>

                                @endforeach

                            @else
                                <p class="text-muted mt-3">No reviews yet.</p>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- ================= SIDEBAR ================= --}}
                <div class="col-md-4">
                    <div class="card shadow-sm course-video-card" >
                        <div class="card-body">
                            <div class="card-header">
<h6 class="fw-semibold mb-0">📚 Course Videos</h6>
</div>

                            <ul class="list-group list-group-flush">
                                @foreach($videoLessons as $lesson)
                                    @php
                                        $today = date('Y-m-d');

                                        $lessonValid =
                                            ($lesson->access_till === null || $lesson->access_till >= $today)
                                            && ($lesson->no_of_times_can_view === null || $lesson->no_of_times_can_view > 0);

                                        $submission = $lesson->homeworkSubmissions
                                            ->where('student_id', auth()->id())
                                            ->first();

                                        $videoPayload = [
                                            'id' => $lesson->id,
                                            'title' => $lesson->title,
                                            'video_type' => $lesson->video_type,
                                            'video_url' => $lesson->video_url,
                                            'video_file' => $lesson->video_file ? asset('storage/' . $lesson->video_file) : null,
                                            'assignment_file' => $lesson->assignment_file ? asset('storage/' . $lesson->assignment_file) : null,
                                            'solution_file' => $lesson->solution_file ? asset('storage/' . $lesson->solution_file) : null,

                                            'has_submission' => (bool) $submission,
                                            'submission_file' => $submission ? asset('storage/' . $submission->assignment_file) : null,
                                            'submission_status' => $submission->status ?? 'submitted',

                                            // 👇 ADD THESE
                                            'teacher_remark' => $submission->teacher_remark ?? null,
                                            'marks' => $submission->marks ?? null,

                                            'is_valid' => $lessonValid,
                                        ];

                                    @endphp

                                    <!--<li class="list-group-item lesson-item" style="cursor:pointer"-->
                                    <!--    data-video='@json($videoPayload)'>-->
                                    <!--    ▶ {{ $lesson->title }}-->

                                    <!--    @if($lesson->assignment_file)-->
                                    <!--        <span class="ms-1 text-primary">📄</span>-->
                                    <!--    @endif-->
                                    <!--</li>-->
                                    <div class="lesson-list">



<li class="lesson-item"
data-video='@json($videoPayload)'>

<div class="lesson-left">

<span class="lesson-icon">▶</span>

<div>

<div class="lesson-title">
{{ $lesson->title }}
</div>

@if($lesson->assignment_file)
<small class="text-primary">Assignment Available</small>
@endif

</div>

</div>

</li>



</div>
                                @endforeach
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const mainVideoContainer = document.getElementById('mainVideoContainer');
            const mainVideoTitle = document.getElementById('mainVideoTitle');
            const assignmentContainer = document.getElementById('assignmentContainer');
            const lessonItems = document.querySelectorAll('.lesson-item');

            const statusMap = {
                submitted: { label: 'Submitted', class: 'bg-primary' },
                checked: { label: 'Checked', class: 'bg-success' },
                reviewed: { label: 'Reviewed', class: 'bg-success' },
                rejected: { label: 'Needs Correction', class: 'bg-danger' },
                resubmitted: { label: 'Re-submitted', class: 'bg-warning text-dark' },
                late: { label: 'Late Submission', class: 'bg-warning text-dark' },
            };

           function youtubeEmbed(url) {

    if (!url) return '';

    // youtu.be format
    if (url.includes('youtu.be/')) {
        return 'https://www.youtube.com/embed/' + url.split('youtu.be/')[1].split('?')[0];
    }

    // youtube watch format
    if (url.includes('youtube.com/watch')) {
        const urlObj = new URL(url);
        return 'https://www.youtube.com/embed/' + urlObj.searchParams.get("v");
    }

    // already embed
    if (url.includes('/embed/')) {
        return url;
    }

    return url;
}

            lessonItems.forEach(item => {
                item.addEventListener('click', function () {

                    lessonItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    const data = JSON.parse(this.getAttribute('data-video'));

                    if (!data.is_valid) {
                        mainVideoContainer.innerHTML = `
                                <div class="alert alert-danger py-5">
                                    Validity expired or watch limit reached
                                </div>`;
                        assignmentContainer.innerHTML = '';
                        mainVideoTitle.textContent = data.title;
                        return;
                    }

                    // VIDEO
                    let videoHtml = '';
                    if (data.video_type === 'YouTube' || data.video_type === 'Vimeo') {
                        videoHtml = `
                                <iframe width="100%" height="480"
                                    src="${youtubeEmbed(data.video_url)}"
                                    frameborder="0" allowfullscreen></iframe>`;
                    } else {
                        videoHtml = `
                                <video width="100%" height="480" controls>
                                    <source src="${data.video_file}" type="video/mp4">
                                </video>`;
                    }

                    mainVideoContainer.innerHTML = videoHtml;
                    mainVideoTitle.textContent = data.title;

                    // ASSIGNMENT
                    if (data.assignment_file) {

                        let submissionHtml = '';

                        if (data.has_submission) {
                            const status = data.submission_status || 'submitted';
                            const badge = statusMap[status] || { label: status, class: 'bg-secondary' };
                            const ext = data.submission_file.split('.').pop().toLowerCase();

                            submissionHtml = `
                <div class="mt-2">
                    <span class="badge ${badge.class}">${badge.label}</span>

                    ${['jpg', 'jpeg', 'png'].includes(ext)
                                    ? `<a href="${data.submission_file}" target="_blank">
                                <img src="${data.submission_file}"
                                     class="img-thumbnail d-block mt-2"
                                     style="max-width:120px;">
                           </a>`
                                    : `<a href="${data.submission_file}" target="_blank"
                               class="btn btn-outline-secondary btn-sm mt-2">
                               📄 View Uploaded File
                           </a>`
                                }
                </div>
            `;

                            // 👇 MARKS & REMARKS
                            if (data.marks !== null || data.teacher_remark) {
                                submissionHtml += `
                    <div class="mt-3 p-3 border rounded bg-light">

                        ${data.marks !== null
                                        ? `<div class="fw-bold text-success mb-1">
                                   🎯 Marks: ${data.marks}
                               </div>`
                                        : ''
                                    }

                        ${data.teacher_remark
                                        ? `<div class="text-muted" style="white-space: pre-line;">
                                   📝 <strong>Teacher Remark:</strong><br>
                                   ${data.teacher_remark}
                               </div>`
                                        : ''
                                    }

                    </div>
                `;
                            }
                        }

                        assignmentContainer.innerHTML = `
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-2">📄 Assignment</h6>

                                        <a href="${data.assignment_file}" target="_blank"
                                           class="btn btn-outline-primary btn-sm">
                                           📥 Download Assignment
                                        </a>

                                        ${!data.has_submission ? `
                                            <form class="mt-2" method="POST"
                                                  action="{{ route('student.homework.upload') }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="video_id" value="${data.id}">
                                                <input type="file" name="assignment_file"
                                                       accept=".pdf,.jpg,.jpeg,.png"
                                                       required
                                                       class="form-control form-control-sm mb-2">
                                                <button class="btn btn-primary btn-sm">Upload</button>
                                            </form>
                                            ` : submissionHtml
                            }

                                        ${(data.has_submission && data.solution_file) ? `
                                            <a href="${data.solution_file}" target="_blank"
                                               class="btn btn-success btn-sm mt-2">
                                               👁 View Solution
                                            </a>` : ''
                            }
                                    </div>
                                </div>`;
                    } else {
                        assignmentContainer.innerHTML = '';
                    }

                    fetch('/video/' + data.id + '/watch', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                });
            });

            // AUTO LOAD FIRST VIDEO
            if (lessonItems.length > 0) {
                lessonItems[0].click();
            }
        });
    </script>
    <script>
        document.getElementById('fullscreenBtn').addEventListener('click',function(){

const videoBox = document.getElementById('mainVideoContainer');

if(videoBox.requestFullscreen){
videoBox.requestFullscreen();
}

});

    </script>

    <style>
        .lesson-item.active {
            background-color: #f0f7ff;
            font-weight: 600;
        }
    </style>
@endsection