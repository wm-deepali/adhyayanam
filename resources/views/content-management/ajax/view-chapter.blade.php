@extends('layouts.app')

@section('title')
    View | Category
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3 class="content-header-title">View Chapter</h3>
                    <a href="{{ route('cm.chapter') }}" class="btn btn-secondary" style="height: fit-content;">← Back</a>
                </div>

                <div class="mt-4">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Examination Commission</th>
                            <td>{{ $chapter->examinationCommission->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $chapter->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sub Category</th>
                            <td>{{ $chapter->subcategory->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Subject</th>
                            <td>{{ $chapter->subject->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $chapter->name }}</td>
                        </tr>
                        <tr>
                            <th>Chapter Number</th>
                            <td>{{ $chapter->chapter_number }}</td>
                        </tr>
                        <!-- <tr>
                            <th>Description</th>
                            <td>{{ $chapter->description }}</td>
                        </tr> -->
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($chapter->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $chapter->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection