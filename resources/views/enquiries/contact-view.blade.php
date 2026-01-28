@extends('layouts.app')

@section('title')
View Contact Enquiry
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Contact Enquiry</h5>
                    <h6 class="card-subtitle text-muted">View enquiry details</h6>
                </div>

                <a href="{{ route('enquiries.contact.us') }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Name</label>
                    <div class="form-control bg-light">{{ $enquiry->name }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Email</label>
                    <div class="form-control bg-light">{{ $enquiry->email }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Website</label>
                    <div class="form-control bg-light">{{ $enquiry->website ?? '-' }}</div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Message</label>
                    <div class="form-control bg-light" style="min-height:120px;">
                        {{ $enquiry->message }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Submitted On</label>
                    <div class="form-control bg-light">
                        {{ $enquiry->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection