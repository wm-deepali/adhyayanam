@extends('front-users.layouts.app')

@section('title')
{{ $course->course_heading }} - Course
@endsection

@section('content')
<section class="content">
    <div class="container">
        <h2 class="mb-3">{{ $course->course_heading }}</h2>
        <p>{{ $course->short_description }}</p>

        <div class="row">
            <!-- Main Video Column -->
            <div class="col-md-8">
                <div class="video-player mb-3">
                    @php
                        $firstVideo = $videoLessons->first();

                        // Convert YouTube/Vimeo URL to embed
                        function youtubeEmbed($url) {
                            if (!$url) return '';
                            if (strpos($url, 'youtube.com/watch?v=') !== false) {
                                $id = explode('v=', $url)[1];
                                if (strpos($id, '&') !== false) $id = explode('&', $id)[0];
                                return 'https://www.youtube.com/embed/' . $id;
                            } elseif (strpos($url, 'vimeo.com') !== false) {
                                $id = explode('/', $url)[3] ?? '';
                                return 'https://player.vimeo.com/video/' . $id;
                            }
                            return $url;
                        }

                        $today = date('Y-m-d');
                        $videoValid = $firstVideo 
                                      && ($firstVideo->access_till === null || $firstVideo->access_till >= $today)
                                      && ($firstVideo->no_of_times_can_view === null || $firstVideo->no_of_times_can_view > 0);
                    @endphp

                    @if($firstVideo)
                        <div id="mainVideoContainer">
                            @if(!$videoValid)
                                <div class="alert alert-danger text-center" style="padding: 200px 0;">
                                    Validity Expired or Maximum watching limit reached
                                </div>
                            @else
                                @if($firstVideo->video_type == 'YouTube' || $firstVideo->video_type == 'Vimeo')
                                    <iframe id="mainVideo" width="100%" height="480" 
                                        src="{{ youtubeEmbed($firstVideo->video_url) }}" 
                                        title="{{ $firstVideo->title }}" frameborder="0" allowfullscreen></iframe>
                                @else
                                    <video id="mainVideo" width="100%" height="480" controls>
                                        <source src="{{ $firstVideo->video_file ? asset('storage/'.$firstVideo->video_file) : $firstVideo->video_url }}" type="video/mp4">
                                        Your browser does not support HTML video.
                                    </video>
                                @endif
                            @endif
                        </div>
                        <h5 class="mt-2" id="mainVideoTitle">{{ $firstVideo->title }}</h5>
                    @else
                        <div class="alert alert-info">No video lessons available.</div>
                    @endif
                </div>

                <div class="course-detail-content">
                    {!! $course->detail_content !!}
                </div>
            </div>

            <!-- Sidebar Topics -->
            <div class="col-md-4">
                <h5>Course Topics</h5>
                <ul class="list-group">
                    @foreach($videoLessons as $lesson)
                        @php
                            $today = date('Y-m-d');
                            $lessonValid = ($lesson->access_till === null || $lesson->access_till >= $today)
                                           && ($lesson->no_of_times_can_view === null || $lesson->no_of_times_can_view > 0);
                        @endphp
                        <li class="list-group-item lesson-item" 
                            data-video-id="{{ $lesson->id }}"
                            data-video-type="{{ $lesson->video_type }}"
                            data-video-file="{{ $lesson->video_file ? asset('storage/'.$lesson->video_file) : '' }}"
                            data-video-url="{{ $lesson->video_url }}"
                            data-is-valid="{{ $lessonValid ? '1' : '0' }}">
                            {{ $lesson->title }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainVideoContainer = document.getElementById('mainVideoContainer');
    const mainVideoTitle = document.getElementById('mainVideoTitle');
    const lessonItems = document.querySelectorAll('.lesson-item');

    function youtubeEmbed(url) {
        if (!url) return '';
        if (url.includes('youtube.com/watch?v=')) {
            let id = url.split('v=')[1];
            if (id.includes('&')) id = id.split('&')[0];
            return 'https://www.youtube.com/embed/' + id;
        } else if (url.includes('vimeo.com')) {
            let parts = url.split('/');
            let id = parts[parts.length - 1];
            return 'https://player.vimeo.com/video/' + id;
        }
        return url;
    }

    lessonItems.forEach(item => {
        item.addEventListener('click', function() {
            const isValid = this.getAttribute('data-is-valid') === '1';
            if (!isValid) {
                alert('Validity Expired or Maximum Watch Limit Reached');
                return;
            }

            const type = this.getAttribute('data-video-type');
            const file = this.getAttribute('data-video-file');
            let url = this.getAttribute('data-video-url');

            let html = '';
            if(type === 'YouTube' || type === 'Vimeo') {
                url = youtubeEmbed(url);
                html = `<iframe id="mainVideo" width="100%" height="480" 
                            src="${url}" frameborder="0" allowfullscreen></iframe>`;
            } else {
                html = `<video id="mainVideo" width="100%" height="480" controls>
                            <source src="${file}" type="video/mp4">
                        </video>`;
            }

            mainVideoContainer.innerHTML = html;
            mainVideoTitle.textContent = this.textContent;

            // Increment watch count for this user/video
            fetch('/video/' + this.getAttribute('data-video-id') + '/watch', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
        });
    });
});
</script>
@endsection
