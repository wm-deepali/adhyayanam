@extends('layouts.app')

@section('title', 'Edit Assignment')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Evaluate Assignment</h5>

                <a href="{{ route('homework.index') }}"
                   class="btn btn-sm btn-secondary">
                    ← Back
                </a>
            </div>

            {{-- BASIC DETAILS --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Student:</strong><br>
                    {{ $submission->student->first_name }}
                    {{ $submission->student->last_name }} <br>
                    <small class="text-muted">{{ $submission->student->email }}</small>
                </div>

                <div class="col-md-6">
                    <strong>Teacher:</strong><br>
                    {{ $submission->teacher->full_name ?? '-' }}
                </div>
            </div>

            <div class="mb-3">
                <strong>Video:</strong>
                {{ $submission->video->title ?? '-' }}
            </div>

            {{-- FILE LINKS --}}
            <div class="d-flex flex-wrap gap-2 mb-4">

                {{-- STUDENT UPLOADED FILE --}}
                <a href="{{ asset('storage/'.$submission->assignment_file) }}"
                   target="_blank"
                   class="btn btn-outline-secondary btn-sm">
                    📄 Student Submission
                </a>

                {{-- ASSIGNMENT FILE --}}
                @if($submission->video && $submission->video->assignment_file)
                    <a href="{{ asset('storage/'.$submission->video->assignment_file) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        📄 Assignment
                    </a>
                @endif

                {{-- SOLUTION FILE --}}
                @if($submission->video && $submission->video->solution_file)
                    <a href="{{ asset('storage/'.$submission->video->solution_file) }}"
                       target="_blank"
                       class="btn btn-success btn-sm">
                        👁 Solution
                    </a>
                @endif
            </div>

            {{-- EVALUATION FORM --}}
            <form method="POST"
                  action="{{ route('homework.update', $submission->id) }}">
                @csrf
                @method('PATCH')

                <div class="row">

                    {{-- STATUS --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['submitted','checked','reviewed','rejected','resubmitted','late'] as $st)
                                <option value="{{ $st }}"
                                    {{ $submission->status === $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MARKS --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Marks</label>
                        <input type="number"
                               name="marks"
                               class="form-control"
                               step="0.01"
                               value="{{ old('marks', $submission->marks) }}"
                               placeholder="Enter marks">
                    </div>

                    {{-- CHECKED AT --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Checked At</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $submission->checked_at ? $submission->checked_at->format('d M Y, h:i A') : '-' }}"
                               disabled>
                    </div>

                </div>

                {{-- TEACHER REMARK --}}
                <div class="mb-3">
                    <label class="form-label">Teacher Remark</label>
                    <textarea name="teacher_remark"
                              rows="4"
                              class="form-control"
                              placeholder="Write feedback for student">{{ old('teacher_remark', $submission->teacher_remark) }}</textarea>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        ✅ Save Changes
                    </button>

                    <a href="{{ route('homework.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
