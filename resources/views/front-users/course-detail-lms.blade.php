@extends('front-users.layouts.app')

@section('title')
    {{ $course->course_heading }} - Course
@endsection

@section('content')
    <section class="content">
        <div class="container">

            {{-- ================= COURSE HEADER ================= --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-1">{{ $course->course_heading }}</h4>
                    <p class="text-muted mb-0">{{ $course->short_description }}</p>
                </div>
            </div>

            <div class="row">
                {{-- ================= MAIN CONTENT ================= --}}
                <div class="col-md-8">

                    {{-- VIDEO PLAYER --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-body p-2">
                            <div id="mainVideoContainer" class="text-center">
                                <div class="text-muted py-5">
                                    Select a video from the right to start learning
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-semibold mb-3" id="mainVideoTitle"></h5>

                    {{-- ASSIGNMENT --}}
                    <div id="assignmentContainer"></div>

                    {{-- COURSE DETAIL --}}
                    <div class="card mt-3">
                        <div class="card-body">
                            {!! $course->detail_content !!}
                        </div>
                    </div>
                </div>

                {{-- ================= SIDEBAR ================= --}}
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">📚 Course Videos</h6>

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

                                    <li class="list-group-item lesson-item" style="cursor:pointer"
                                        data-video='@json($videoPayload)'>
                                        ▶ {{ $lesson->title }}

                                        @if($lesson->assignment_file)
                                            <span class="ms-1 text-primary">📄</span>
                                        @endif
                                    </li>
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
                if (url.includes('youtube.com/watch?v=')) {
                    let id = url.split('v=')[1];
                    if (id.includes('&')) id = id.split('&')[0];
                    return 'https://www.youtube.com/embed/' + id;
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

            ${
                ['jpg','jpeg','png'].includes(ext)
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

                ${
                    data.marks !== null
                    ? `<div class="fw-bold text-success mb-1">
                           🎯 Marks: ${data.marks}
                       </div>`
                    : ''
                }

                ${
                    data.teacher_remark
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

    <style>
        .lesson-item.active {
            background-color: #f0f7ff;
            font-weight: 600;
        }
    </style>
@endsection