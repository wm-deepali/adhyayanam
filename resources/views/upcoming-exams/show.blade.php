@extends('layouts.app')

@section('title')
    Upcoming Exams | View
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <h5 class="card-title">Upcoming Exam Details</h5>
                        <h6 class="card-subtitle text-muted">View information for this exam.</h6>
                    </div>
                    <div>
                        <a href="{{ route('upcoming.exam.index') }}" class="btn btn-secondary">Back</a>
                        @if(\App\Helpers\Helper::canAccess('manage_upcoming_exams_edit'))
                            <a href="{{ route('upcoming.exam.edit', $exam->id) }}" class="btn btn-primary">Edit</a>
                        @endif
                    </div>
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Examination Commission</th>
                            <td>{{ $exam->exam_commission->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Examination Name</th>
                            <td>{{ $exam->examination_name }}</td>
                        </tr>
                        <tr>
                            <th>Date of Advertisement</th>
                            <td>{{ \Carbon\Carbon::parse($exam->advertisement_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Form Distribution Date</th>
                            <td>{{ \Carbon\Carbon::parse($exam->form_distribution_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Last Date for Submission</th>
                            <td>{{ \Carbon\Carbon::parse($exam->submission_last_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Examination Date</th>
                            <td>{{ \Carbon\Carbon::parse($exam->examination_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Link</th>
                            <td>
                                @if($exam->link)
                                    <a href="{{ $exam->link }}" target="_blank">{{ $exam->link }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>PDF</th>
                            <td>
                                @if($exam->pdf)
                                    <a href="{{ url('storage/' . $exam->pdf) }}" target="_blank">View PDF</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $exam->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $exam->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection