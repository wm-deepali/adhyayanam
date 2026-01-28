@extends('layouts.app')

@section('title')
    View Direct Enquiry
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Direct Enquiry Details</h5>
                    <h6 class="card-subtitle text-muted">
                        View enquiry information
                    </h6>
                </div>

                <a href="{{ route('enquiries.direct.call') ?? url()->previous() }}"
                   class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Query For</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->query_for ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Full Name</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->full_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Mobile Number</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->mobile ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Email</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->email ?? '-' }}
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Details</label>
                    <div class="form-control bg-light" style="min-height:120px;">
                        {{ $enquiry->details ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Submitted On</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Attached File</label>
                    <div class="form-control bg-light">
                        @if($enquiry->file)
                            <a href="{{ asset('storage/' . $enquiry->file) }}"
                               class="btn btn-sm btn-primary"
                               download>
                                <i class="fa fa-download"></i> Download File
                            </a>
                        @else
                            <span class="text-muted">No file uploaded</span>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection