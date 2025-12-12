<div class="bg-light rounded">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">{{ $title }}</h4>

            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Test Paper</th>
                        <th>Paper Type</th>
                        <th>Score</th>
                        <th>Total Marks</th>
                        <th>Assigned Teacher</th>
                        <th>Status</th>
                        <th>Attempted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($attempts as $index => $attempt)
                        @php
                            $student = $attempt->student;
                            $test = $attempt->test;
                        @endphp

                        <tr>
                            <td>{{ ($attempts->firstItem() + $index) }}</td>

                            <td>
                                {{ $student->name ?? 'Unknown' }}
                                <br>
                                <small class="text-muted">{{ $student->email ?? '-' }}</small>
                            </td>

                            <td>
                                {{ $test->name ?? '-' }}
                                <br>
                                <small class="text-muted">Test ID: {{ $test->id ?? '-' }}</small>
                            </td>

                            <td>
                                @php
                                    $paperType = $attempt->test->paper_type;
                                    $typeName = match ($paperType) {
                                        1 => 'Previous Year',
                                        2 => 'Current Affair',
                                        default => (
                                            is_null($attempt->test->topic_id) && is_null($attempt->test->subject_id) && is_null($attempt->test->chapter_id)
                                            ? 'Full Test'
                                            : (!is_null($attempt->test->subject_id) && is_null($attempt->test->chapter_id)
                                                ? 'Subject Wise'
                                                : (!is_null($attempt->test->chapter_id) && is_null($attempt->test->topic_id)
                                                    ? 'Chapter Wise'
                                                    : (!is_null($attempt->test->topic_id)
                                                        ? 'Topic Wise'
                                                        : '-'
                                                    )
                                                )
                                            )
                                        )
                                    };
                                @endphp

                                {{ $typeName }} ({{ ucfirst($attempt->test->test_paper_type) }})
                            </td>

                            <td>
                                @if($attempt->status == 'published')

                                    @php
                                        $score = $attempt->final_score;
                                        $total = $attempt->actual_marks;

                                        // Percentage calculation
                                        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

                                        // Get division from model accessor
                                        $division = $attempt->result_division;

                                        // Badge colors
                                        $badgeClass =
                                            ($division == 'Fail') ? 'bg-danger' :
                                            (($division == 'Poor') ? 'bg-warning text-dark' :
                                                (($division == 'Average') ? 'bg-info text-dark' :
                                                    (($division == 'Good') ? 'bg-primary' :
                                                        (($division == 'Excellent') ? 'bg-success' : 'bg-secondary'))));
                                    @endphp

                                    {{-- SCORE --}}
                                    <div><strong>{{ $score }}/{{ $total }}</strong></div>

                                    {{-- PERCENTAGE --}}
                                    <small class="text-muted">{{ $percentage }}%</small>

                                    {{-- DIVISION --}}
                                    <div>
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $division ?? 'N/A' }}
                                        </span>
                                    </div>

                                @else
                                    <span class="text-muted">Waiting Evaluation</span>
                                @endif
                            </td>

                            <td>{{ $attempt->actual_marks }}</td>
                            <td>
                                @if($attempt->assigned_teacher_id)
                                    <span class="badge bg-info text-dark">
                                        {{ $attempt->assignedTeacher->full_name ?? 'Unknown' }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $attempt->assignedTeacher->email ?? '' }}</small>
                                @else
                                    <span class="text-muted">Not Assigned</span>
                                @endif
                            </td>

                            <td>
                                @if($attempt->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending Evaluation</span>
                                @elseif($attempt->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($attempt->status) }}</span>
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($attempt->created_at)->format('d M Y h:i A') }}
                            </td>

                            <td>

                                {{-- VIEW RESULT BUTTON ALWAYS VISIBLE --}}
                                <a href="{{ route('admin.evaluate-attempt', base64_encode($attempt->id)) }}"
                                    class="btn btn-sm btn-primary mb-1">
                                    View Result
                                </a>

                                {{-- SHOW Assign Teacher ONLY WHEN: pending AND NOT MCQ --}}
                                @if($attempt->status == 'pending' && strtolower($attempt->test->test_paper_type) != 'mcq')
                                    <button class="btn btn-sm btn-warning mb-1"
                                        onclick="openAssignTeacherModal('{{ $attempt->id }}')">
                                        Assign Teacher
                                    </button>


                                    {{-- DELETE BUTTON --}}
                                    <form action="{{ route('admin.delete-attempt', $attempt->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this attempt?');">
                                            Delete
                                        </button>
                                    </form>
                                @endif

                            </td>

                        </tr>

                    @endforeach
                </tbody>

            </table>

            <div class="mt-2">
                {{ $attempts->links() }}
            </div>

        </div>
    </div>
</div>

<!-- Assign Teacher Modal -->
<div class="modal fade" id="assignTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="assignTeacherForm" method="POST" action="{{ route('admin.assign-teacher-save') }}">
            @csrf

            <input type="hidden" name="attempt_id" id="assign_attempt_id">

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Assign Teacher for Evaluation</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label"><strong>Select Teacher:</strong></label>
                        <select class="form-select" name="teacher_id" required>
                            <option value="">-- Choose Teacher --</option>

                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->name }} ({{ $teacher->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openAssignTeacherModal(attemptId) {
        document.getElementById("assign_attempt_id").value = attemptId;
        new bootstrap.Modal(document.getElementById("assignTeacherModal")).show();
    }
</script>