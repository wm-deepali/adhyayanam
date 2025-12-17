@extends('layouts.teacher-app')

@section('title', 'Submitted Assignments')

@section('content')
    <div class="bg-light rounded p-3">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mb-0">Submitted Assignments</h5>

                    {{-- STATUS FILTER --}}
                    <form method="GET">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            @foreach(['submitted', 'checked', 'rejected'] as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Video</th>
                                <th>Teacher</th>
                                <th>Assignment</th>
                                <th>Status</th>
                                <th>Uploaded File</th>
                                <th>Solution</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($submissions as $submission)
                                                @php
                                                    $statusMap = [
                                                        'submitted' => ['label' => 'Submitted', 'class' => 'bg-primary'],
                                                        'checked' => ['label' => 'Checked', 'class' => 'bg-success'],
                                                        'reviewed' => ['label' => 'Reviewed', 'class' => 'bg-success'],
                                                        'rejected' => ['label' => 'Needs Correction', 'class' => 'bg-danger'],
                                                        'resubmitted' => ['label' => 'Re-submitted', 'class' => 'bg-warning text-dark'],
                                                        'late' => ['label' => 'Late Submission', 'class' => 'bg-warning text-dark'],
                                                    ];

                                                    $badge = $statusMap[$submission->status]
                                                        ?? ['label' => ucfirst($submission->status), 'class' => 'bg-secondary'];

                                                    $filePath = $submission->assignment_file;
                                                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                @endphp

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    {{-- STUDENT --}}
                                                    <td>
                                                        {{ $submission->student->first_name }}
                                                        {{ $submission->student->last_name }} <br>
                                                        <small class="text-muted">{{ $submission->student->email }}</small>
                                                    </td>

                                                    {{-- VIDEO --}}
                                                    <td>{{ $submission->video->title ?? '-' }}</td>

                                                    {{-- TEACHER --}}
                                                    <td>{{ $submission->teacher->full_name ?? '-' }}</td>

                                                    {{-- ASSIGNMENT (Teacher File) --}}
                                                    <td>
                                                        @if($submission->video && $submission->video->assignment_file)
                                                            <a href="{{ asset('storage/' . $submission->video->assignment_file) }}" target="_blank"
                                                                class="btn btn-outline-primary btn-sm">
                                                                📄 View Assignment
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>

                                                    {{-- STATUS --}}
                                                    <td>
                                                        <span class="badge {{ $badge['class'] }}">
                                                            {{ $badge['label'] }}
                                                        </span>
                                                    </td>

                                                    {{-- UPLOADED FILE (Student) --}}
                                                    <td>
                                                        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $filePath) }}" class="img-thumbnail"
                                                                    style="max-width:80px;">
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                                                class="btn btn-outline-secondary btn-sm">
                                                                📄 View File
                                                            </a>
                                                        @endif
                                                    </td>

                                                    {{-- SOLUTION --}}
                                                    <td>
                                                        @if($submission->video && $submission->video->solution_file)
                                                            <a href="{{ asset('storage/' . $submission->video->solution_file) }}" target="_blank"
                                                                class="btn btn-success btn-sm">
                                                                👁 View
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>

                                                    {{-- SUBMITTED AT --}}
                                                    <td>
                                                        {{ $submission->submitted_at
                                ? $submission->submitted_at->format('d M Y, h:i A')
                                : '-' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('teacher.homework.edit', $submission->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            ✏ Evaluate
                                                        </a>

                                                    </td>
                                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No submissions found.
                                    </td>

                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $submissions->links() }}
            </div>
        </div>
    </div>
@endsection