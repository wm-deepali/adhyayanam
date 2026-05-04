@extends('layouts.app')

@section('title', 'Videos Summary')

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                <h5>Videos Summary</h5>

                @if(request('student_id'))
                    <h6 class="text-primary">
                        Showing videos watched by Student ID: {{ request('student_id') }}
                    </h6>
                @else
                    <small class="text-muted">Aggregated video engagement data</small>
                @endif

                <form method="GET" class="d-flex gap-2 my-3">

                    {{-- ✅ KEEP student_id --}}
                    <input type="hidden" name="student_id" value="{{ request('student_id') }}">

                    <input type="text" name="search" class="form-control" placeholder="Search course or video"
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

                                @if(request('student_id'))
                                    <th>Views</th>
                                    <th>Access Till</th>
                                @else
                                    <th>Total Views</th>
                                    <th>Students Watched</th>
                                    <th>Avg Views / Student</th>
                                    <th>Action</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                                <tr>
                                    <td>{{ $video->course->course_heading ?? '-' }}</td>
                                    <td>{{ $video->title }}</td>
                                    <td>{{ $video->teacher->full_name ?? '-' }}</td>

                                    @if(request('student_id'))
                                        {{-- ✅ ONLY STUDENT DATA --}}
                                        <td>{{ $video->total_views }}</td>
                                        <td>{{ $video->access_till
                                        ? \Carbon\Carbon::parse($video->access_till)->format('d M Y')
                                        : 'Unlimited' }}</td>
                                    @else
                                                        {{-- GLOBAL DATA --}}
                                                        <td>{{ $video->total_views }}</td>
                                                        <td>{{ $video->total_students }}</td>
                                                        <td>
                                                            {{ $video->total_students
                                        ? round($video->total_views / $video->total_students, 2)
                                        : 0 }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('students.student-video-detail', $video->id) }}" title="View Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                    @endif

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