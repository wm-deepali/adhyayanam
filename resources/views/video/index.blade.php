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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Search Box -->
                        <form method="GET" action="{{ route('video.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by title"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-success">Search</button>
                        </form>

                        <!-- Add New Button -->
                        @if(\App\Helpers\Helper::canAccess('manage_videos_add'))
                            <a href="{{ route('video.create') }}" class="btn btn-primary">Add New</a>
                        @endif
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="videoTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos"
                                type="button" role="tab">
                                🎥 Videos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="live-tab" data-bs-toggle="tab" data-bs-target="#live" type="button"
                                role="tab">
                                📡 Live Classes
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="videoTabContent">

                        {{-- ===================== VIDEOS TAB ===================== --}}
                        <div class="tab-pane fade show active" id="videos" role="tabpanel">
                            @if($videos->count())
                                <table class="table table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Title</th>
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
                                                <td>{{ $topic->course->name ?? "-" }}</td>
                                                <td>{{ $topic->category->name ?? "-" }}</td>
                                                <td>{{ $topic->course_type }}</td>
                                                <td>{{ $topic->duration }}</td>
                                                <td>
                                                    @if ($topic->assignment)
                                                        <img src="{{ asset('storage/' . $topic->assignment) }}" alt="{{ $topic->name }}"
                                                            style="max-width: 80px;">
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
                                                    @php
                                                        $canView = \App\Helpers\Helper::canAccess('manage_video');
                                                        $canEdit = \App\Helpers\Helper::canAccess('manage_videos_edit');
                                                        $canDelete = \App\Helpers\Helper::canAccess('manage_videos_delete');
                                                    @endphp

                                                    @if($canView || $canEdit || $canDelete)
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                                data-bs-toggle="dropdown">
                                                                Actions
                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                {{-- VIEW --}}
                                                                @if($canView)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('video.show', $topic->id) }}">
                                                                            <i class="fa fa-eye text-primary me-2"></i> View
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                {{-- EDIT --}}
                                                                @if($canEdit)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('video.edit', $topic->id) }}">
                                                                            <i class="fa fa-edit text-success me-2"></i> Edit
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                {{-- DELETE --}}
                                                                @if($canDelete)
                                                                    <li>
                                                                        <form action="{{ route('video.destroy', $topic->id) }}"
                                                                            method="POST" onsubmit="return confirm('Are you sure?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger">
                                                                                <i class="fa fa-trash me-2" style="color:#dc3545!important"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endif

                                                            </ul>
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
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
                        <div class="tab-pane fade" id="live" role="tabpanel">
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
                                                <td>{{ $class->course->name ?? "-" }}</td>
                                                <td>{{ optional($class->teacher)->full_name ?? 'N/A' }}</td>
                                                <td>{{ $class->schedule_date }}</td>
                                                <td>{{ $class->start_time }}</td>
                                                <td>{{ $class->end_time }}</td>
                                                <td>{{ $class->status ? 'Active' : 'Inactive' }}</td>
                                                <td>
    @php
        $canView   = \App\Helpers\Helper::canAccess('manage_videos');
        $canEdit   = \App\Helpers\Helper::canAccess('manage_videos_edit');
        $canDelete = \App\Helpers\Helper::canAccess('manage_videos_delete');
    @endphp

    @if($canView || $canEdit || $canDelete)
        <div class="dropdown">
            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                data-bs-toggle="dropdown">
                Actions
            </button>

            <ul class="dropdown-menu">

                @if($canView)
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('video.show', $class->id) }}">
                            <i class="fa fa-eye text-primary me-2"></i> View
                        </a>
                    </li>
                @endif

                @if($canEdit)
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('video.edit', $class->id) }}">
                            <i class="fa fa-edit text-success me-2"></i> Edit
                        </a>
                    </li>
                @endif

                @if($canDelete)
                    <li>
                        <form action="{{ route('video.destroy', $class->id) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa fa-trash me-2" style="color:#dc3545!important"></i> Delete
                            </button>
                        </form>
                    </li>
                @endif

            </ul>
        </div>
    @else
        -
    @endif
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