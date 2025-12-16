@extends('layouts.app')

@section('title')
    View | Test Planner
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">View Test Planner</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Detailed information about this Test Planner.</h6>
                    </div>
                    <div>
                        <a href="{{ route('test.planner.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>

                        @if(\App\Helpers\Helper::canAccess('manage_test_planner_edit'))
                            <a href="{{ route('test.planner.edit', $testPlanner->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        @endif
                    </div>

                </div>

                <div class="mt-3">@include('layouts.includes.messages')</div>

                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Title:</label><br>
                        <span>{{ $testPlanner->title ?? '--' }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Start Date:</label><br>
                        <span>{{ \Carbon\Carbon::parse($testPlanner->start_date)->format('d M Y') ?? '--' }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Status:</label><br>
                        @if ($testPlanner->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Created On:</label><br>
                        <span>{{ $testPlanner->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Updated On:</label><br>
                        <span>{{ $testPlanner->updated_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">PDF:</label><br>
                        @if ($testPlanner->pdf)
                            <a href="{{ asset('storage/' . $testPlanner->pdf) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-file-pdf-o"></i> View PDF
                            </a>
                        @else
                            <span class="text-muted">No PDF Uploaded</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Short Description:</label>
                    <div class="border rounded p-2 bg-white">
                        {{ $testPlanner->short_description ?? '--' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Detailed Content:</label>
                    <div class="border rounded p-3 bg-white">
                        {!! $testPlanner->detail_content ?? '--' !!}
                    </div>
                </div>

                @if(\App\Helpers\Helper::canAccess('manage_test_planner_delete'))
                    <div class="mt-4">
                        <form action="{{ route('test.planner.delete', $testPlanner->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this test planner?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection