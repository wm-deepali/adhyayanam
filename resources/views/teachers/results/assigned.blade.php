@extends('layouts.teacher-app')

@section('content')

<div class="card">
    <div class="card-header bg-warning text-dark">
        <h5>Assigned Tests (Pending Evaluation)</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Test</th>
                    <th>Score</th>
                    <th>Status</th>
                    <th>Assigned On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($attempts as $i => $attempt)
                    <tr>
                        <td>{{ $attempts->firstItem() + $i }}</td>
                        <td>{{ $attempt->student->name }}</td>
                        <td>{{ $attempt->test->name }}</td>
                        <td>{{ $attempt->final_score }}</td>

                        <td>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </td>

                        <td>{{ $attempt->created_at->format('d M Y h:i A') }}</td>

                        <td>
                            <a href="{{ route('teacher.results.evaluate', base64_encode($attempt->id)) }}"
                               class="btn btn-sm btn-primary">
                                Evaluate
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{ $attempts->links() }}
    </div>
</div>

@endsection
