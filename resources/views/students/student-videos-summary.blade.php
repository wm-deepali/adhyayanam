@extends('layouts.app')

@section('title','Videos Summary')

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <h5>Videos Summary</h5>
            <small class="text-muted">Aggregated video engagement data</small>

            <form method="GET" class="d-flex gap-2 my-3">
                <input type="text" name="search" class="form-control"
                       placeholder="Search course or video"
                       value="{{ request('search') }}">
                <button class="btn btn-success">Search</button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Video</th>
                            <th>Teacher</th>
                            <th>Total Views</th>
                            <th>Students Watched</th>
                            <th>Avg Views / Student</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                            <tr>
                                <td>{{ $video->course->course_heading ?? '-' }}</td>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->teacher->full_name ?? '-' }}</td>
                                <td>{{ $video->total_views }}</td>
                                <td>{{ $video->total_students }}</td>
                                <td>
                                    {{ $video->total_students
                                        ? round($video->total_views / $video->total_students, 2)
                                        : 0 }}
                                </td>
                                <td>
                                    <a href="{{ route('students.student-video-detail', $video->id) }}"
                                       title="View Student Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No video data found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $videos->links() }}
            </div>

        </div>
    </div>
</div>
@endsection