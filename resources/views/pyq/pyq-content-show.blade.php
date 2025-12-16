@extends('layouts.app')

@section('title')
    Pyq Content Details
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pyq Content Details</h5>
            <h6 class="card-subtitle mb-2 text-muted">View the details of the content.</h6>

            <div class="mt-3">
                <a href="{{ route('pyq.content.index') }}" class="btn btn-secondary mb-3">Back to List</a>
            </div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Examination Commission</th>
                        <td>{{ $pyqContent->examinationCommission->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $pyqContent->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sub Category</th>
                        <td>{{ $pyqContent->subCategory->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $pyqContent->subject->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Heading</th>
                        <td>{{ $pyqContent->heading }}</td>
                    </tr>
                    <tr>
                        <th>Detail Content</th>
                        <td>{!! $pyqContent->detail_content !!}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $pyqContent->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $pyqContent->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
