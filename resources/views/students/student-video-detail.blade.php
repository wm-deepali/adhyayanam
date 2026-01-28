@extends('layouts.app')

@section('title','Video Detail')

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <h5>{{ $video->title }}</h5>
            <small class="text-muted">
                Course: {{ $video->course->course_heading ?? '-' }}
            </small>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Mobile</th>
                            <th>Watched Count</th>
                            <th>Access Till</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($progress as $row)
                            <tr>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->user->mobile }}</td>
                                <td>{{ $row->watched_count }}</td>
                                <td>
                                    {{ $row->access_till
                                        ? \Carbon\Carbon::parse($row->access_till)->format('d M Y')
                                        : 'Unlimited' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No student has watched this video yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection