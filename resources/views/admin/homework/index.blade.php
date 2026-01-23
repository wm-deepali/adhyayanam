@extends('layouts.app')

@section('title', 'Submitted Assignments')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Submitted Assignments</h5>

                <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
                    ⬅ Back
                </a>
            </div>

            {{-- FILTERS --}}
            <form method="GET" class="d-flex gap-2 mb-3">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="Search by title or teacher or student">

                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    @foreach(['submitted', 'checked', 'rejected'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-sm btn-primary">Search</button>
            </form>

            {{-- TABLE --}}
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
                            <th>Action</th>
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
                                $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $submission->student->first_name }}
                                    {{ $submission->student->last_name }} <br>
                                    <small class="text-muted">{{ $submission->student->email }}</small>
                                </td>

                                <td>{{ $submission->video->title ?? '-' }}</td>

                                <td>{{ $submission->teacher->full_name ?? '-' }}</td>

                                <td>
                                    @if($submission->video && $submission->video->assignment_file)
                                        <a href="{{ asset('storage/'.$submission->video->assignment_file) }}"
                                           target="_blank"
                                           class="btn btn-outline-primary btn-sm">
                                            📄 View Assignment
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $badge['class'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>

                                <td>
                                    @if($filePath && in_array($ext, ['jpg','jpeg','png']))
                                        <a href="{{ asset('storage/'.$filePath) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$filePath) }}"
                                                 class="img-thumbnail"
                                                 style="max-width:80px;">
                                        </a>
                                    @elseif($filePath)
                                        <a href="{{ asset('storage/'.$filePath) }}"
                                           target="_blank"
                                           class="btn btn-outline-secondary btn-sm">
                                            📄 View File
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    @if($submission->video && $submission->video->solution_file)
                                        <a href="{{ asset('storage/'.$submission->video->solution_file) }}"
                                           target="_blank"
                                           class="btn btn-success btn-sm">
                                            👁 View
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    {{ $submission->submitted_at
                                        ? $submission->submitted_at->format('d M Y, h:i A')
                                        : '-' }}
                                </td>

                                <td>
                                    <a href="{{ route('homework.edit', $submission->id) }}"
                                       class="btn btn-sm btn-warning">
                                        ✏ Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
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
