@extends('layouts.app')

@section('title')
Manage Video
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Manage Video & Live Classes</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage your uploaded videos and live classes.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <a href="{{ route('video.create') }}" class="btn btn-primary mb-3">Add New</a>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="videoTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="true">
                            🎥 Videos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="live-tab" data-bs-toggle="tab" data-bs-target="#live" type="button" role="tab" aria-controls="live" aria-selected="false">
                            📡 Live Classes
                        </button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content mt-3" id="videoTabContent">
                    {{-- ===================== VIDEOS TAB ===================== --}}
                    <div class="tab-pane fade show active" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                        @if($videos->count())
                            <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Video Title</th>
                                        <th>Chapter</th>
                                        <th>Course</th>
                                        <th>Category</th>
                                        <th>Course Type</th>
                                        <th>Duration</th>
                                        <th>Assignment</th>
                                        <th>Source</th>
                                        <th>Ratings</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $topic)
                                    <tr>
                                        <td>{{ $topic->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $topic->title }}</td>
                                        <td>{{ $topic->chapter->name ?? "-" }}</td>
                                        <td>{{ $topic->courses->name ?? "-" }}</td>
                                        <td>{{ $topic->coursecategory->name ?? "-" }}</td>
                                        <td>{{ $topic->course_type }}</td>
                                        <td>{{ $topic->duration }}</td>
                                        <td>
                                            @if ($topic->assignment)
                                                <img src="{{ asset('storage/' . $topic->assignment) }}" alt="{{ $topic->name }}" style="max-width: 80px;">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $topic->video_type }}</td>
                                        <td>
                                            @php
                                                $rating = $topic->rating;
                                                $fullStars = floor($rating);
                                                $hasHalfStar = ceil($rating - $fullStars) > 0;
                                                $totalStars = 5;
                                            @endphp
                                            @for ($i = 1; $i <= $fullStars; $i++)
                                                <i class="fa fa-star text-warning"></i>
                                            @endfor
                                            @if ($hasHalfStar)
                                                <i class="fa fa-star-half-alt text-warning"></i>
                                            @endif
                                            @for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < $totalStars; $i++)
                                                <i class="fa fa-star text-muted"></i>
                                            @endfor
                                        </td>
                                        <td>{{ $topic->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('video.edit', $topic->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('video.destroy', $topic->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-muted mt-3">No videos found.</p>
                        @endif
                    </div>

                    {{-- ===================== LIVE CLASSES TAB ===================== --}}
                    <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
                        @if($liveClasses->count())
                            <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Teacher</th>
                                        <th>Schedule Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($liveClasses as $class)
                                    <tr>
                                        <td>{{ $class->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $class->title }}</td>
                                        <td>{{ $class->courses->name ?? "-" }}</td>
                                        <td>{{ optional($class->teacher)->full_name ?? 'N/A' }}</td>
                                        <td>{{ $class->schedule_date }}</td>
                                        <td>{{ $class->start_time }}</td>
                                        <td>{{ $class->end_time }}</td>
                                        <td>{{ $class->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('video.edit', $class->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('video.destroy', $class->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-muted mt-3">No live classes found.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
