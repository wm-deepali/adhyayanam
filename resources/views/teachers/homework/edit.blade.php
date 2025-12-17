@extends('layouts.teacher-app')

@section('title', 'Evaluate Assignment')

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">

            <h5 class="mb-3">Evaluate Assignment</h5>

            {{-- BASIC INFO --}}
            <div class="mb-3">
                <strong>Student:</strong>
                {{ $submission->student->first_name }}
                {{ $submission->student->last_name }} <br>

                <strong>Video:</strong>
                {{ $submission->video->title ?? '-' }}
            </div>

            {{-- FILE LINKS --}}
            <div class="mb-3 d-flex gap-2 flex-wrap">
                <a href="{{ asset('storage/'.$submission->assignment_file) }}"
                   target="_blank"
                   class="btn btn-outline-secondary btn-sm">
                    📄 Student Submission
                </a>

                @if($submission->video && $submission->video->assignment_file)
                    <a href="{{ asset('storage/'.$submission->video->assignment_file) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        📄 Assignment
                    </a>
                @endif

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
                  action="{{ route('teacher.homework.update', $submission->id) }}">
                @csrf
                @method('PATCH')

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['checked','rejected'] as $st)
                            <option value="{{ $st }}"
                                {{ $submission->status === $st ? 'selected' : '' }}>
                                {{ ucfirst($st) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MARKS --}}
                <div class="mb-3">
                    <label class="form-label">Marks</label>
                    <input type="number"
                           name="marks"
                           step="0.01"
                           value="{{ old('marks', $submission->marks) }}"
                           class="form-control"
                           placeholder="Enter marks">
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
                    <button class="btn btn-success">
                        ✅ Save Evaluation
                    </button>

                    <a href="{{ route('teacher.homework.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
