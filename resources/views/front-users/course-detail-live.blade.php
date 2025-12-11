@extends('front-users.layouts.app')

@section('title')
    {{ $course->course_heading }} - Live Classes
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $course->course_heading }} - Live Classes Schedule</h5>
                        <p class="mb-0 card-subtitle text-muted">{{ $course->short_description }}</p>
                    </div>
                    <div class="card-body">
                        @if($liveClasses->isEmpty())
                            <div class="alert alert-info">No live classes scheduled yet.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Teacher</th>
                                        <th>Join Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($liveClasses as $key => $class)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $class->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($class->schedule_date)->format('d M, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}</td>
                                            <td>{{ optional($class->teacher)->full_name ?? '-' }}</td>
                                            <td>
                                                @if($class->status == 'active')
                                                    <a href="{{ $class->live_link }}" target="_blank"
                                                        class="btn btn-success btn-sm">Join Class</a>
                                                @else
                                                    <span class="text-muted">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
    </div>
    </section>
@endsection