@extends('layouts.app')

@section('title', 'View | Syllabus')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

<div class="bg-light rounded">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <div>
                    <h5 class="card-title mb-1 font-weight-bold">View Syllabus</h5>
                    <small class="text-muted">Syllabus details overview</small>
                </div>
                <div>
                    <a href="{{ route('syllabus.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('syllabus.edit', $syllabus->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <div class="mt-2">@include('layouts.includes.messages')</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Examination Commission:</label>
                    <div class="text-muted">{{ $syllabus->commission->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Category:</label>
                    <div class="text-muted">{{ $syllabus->category->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Sub Category:</label>
                    <div class="text-muted">{{ $syllabus->subCategory->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Subject:</label>
                    <div class="text-muted">{{ $syllabus->subject->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Title:</label>
                    <div class="text-dark">{{ $syllabus->title }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Type:</label>
                    <div class="text-dark">{{ ucfirst($syllabus->type) }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Status:</label><br>
                    @if ($syllabus->status)
                        <span class="badge badge-success px-2 py-1">Active</span>
                    @else
                        <span class="badge badge-danger px-2 py-1">Inactive</span>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">PDF File:</label><br>
                    @if ($syllabus->pdf)
                        <a href="{{ asset('storage/' . $syllabus->pdf) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-file-pdf-o"></i> View PDF
                        </a>
                    @else
                        <span class="text-muted">No PDF uploaded</span>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Created On:</label>
                    <div class="text-muted">{{ $syllabus->created_at->format('d M Y, h:i A') }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Updated On:</label>
                    <div class="text-muted">{{ $syllabus->updated_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            @if ($syllabus->detail_content)
                <div class="mt-4">
                    <label class="font-weight-bold">Detailed Content:</label>
                    <div class="border p-3 rounded bg-white shadow-sm">
                        {!! $syllabus->detail_content !!}
                    </div>
                </div>
            @endif

            <div class="mt-4 text-right">
                <form action="{{ route('syllabus.destroy', $syllabus->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to delete this syllabus?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
