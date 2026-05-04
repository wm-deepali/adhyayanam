@extends('layouts.teacher-app')

@section('title', 'Assigned Live Classes')

@section('content')
<div class="bg-light rounded p-2">

    {{-- HEADER --}}
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Assigned Live Classes</h5>
                <small class="text-muted">All live classes assigned to you</small>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Show Assignment</th>
                            <th>Assignment</th>
                            <th>Solution</th>
                            <th>Status</th>
                            <th>Link</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($liveClasses as $index => $live)

                            @php
                                $start = \Carbon\Carbon::parse($live->schedule_date . ' ' . $live->start_time);
                                $end = \Carbon\Carbon::parse($live->schedule_date . ' ' . $live->end_time);
                                $now = now();
                            @endphp

                            <tr>
                                <td>{{ $liveClasses->firstItem() + $index }}</td>
                                <td>{{ $live->title }}</td>
                                <td>{{ $live->course->name ?? '-' }}</td>

                                <td>{{ \Carbon\Carbon::parse($live->schedule_date)->format('d M Y') }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($live->start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($live->end_time)->format('h:i A') }}
                                </td>

                                <td>
                                    <form action="{{ route('teacher.live.assignment.toggle', $live->id) }}"
      method="POST"
      class="mb-1">
    @csrf

    <input type="hidden" name="show_assignment" value="0">

    <div class="form-check form-switch">
        <input class="form-check-input"
               type="checkbox"
               name="show_assignment"
               value="1"
               onchange="this.form.submit()"
               {{ $live->show_assignment ? 'checked' : '' }}>

        <label class="form-check-label">
            Show
        </label>
    </div>
</form>
                                </td>
                                {{-- ASSIGNMENT --}}
                                <td>
                                    {{-- VIEW --}}
                                    @if($live->assignment_file)
                                        <a href="{{ asset('storage/'.$live->assignment_file) }}"
                                           target="_blank"
                                           class="btn btn-info btn-sm mt-1 w-100">
                                            View
                                        </a>
                                    @endif

                                    {{-- UPLOAD --}}
                                    <form action="{{ route('teacher.live.assignment.upload', $live->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="assignment_file" class="form-control form-control-sm mt-1">
                                        <button class="btn btn-primary btn-sm mt-1 w-100">Upload</button>
                                    </form>

                                </td>

                                {{-- SOLUTION --}}
                                <td>

                                    @if($live->solution_file)
                                        <a href="{{ asset('storage/'.$live->solution_file) }}"
                                           target="_blank"
                                           class="btn btn-success btn-sm w-100">
                                            View
                                        </a>
                                    @endif

                                    <form action="{{ route('teacher.live.solution.upload', $live->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="solution_file" class="form-control form-control-sm mt-1">
                                        <button class="btn btn-dark btn-sm mt-1 w-100">Upload</button>
                                    </form>

                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if($now->lt($start))
                                        <span class="badge bg-info">Upcoming</span>
                                    @elseif($now->between($start, $end))
                                        <span class="badge bg-success">Live</span>
                                    @else
                                        <span class="badge bg-secondary">Completed</span>
                                    @endif
                                </td>

                                {{-- LINK --}}
                                <td>
                                    @if($now->between($start, $end))
                                        <a href="{{ $live->live_link }}" target="_blank" class="btn btn-success btn-sm">
                                            Join
                                        </a>
                                    @else
                                        <span class="text-muted">Unavailable</span>
                                    @endif
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No live classes assigned
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $liveClasses->links() }}
            </div>

        </div>
    </div>

</div>
@endsection