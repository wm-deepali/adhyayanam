@extends('layouts.app')

@section('title')
    View Career Details
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- Header with Back button --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Career Details</h5>
                    <h6 class="card-subtitle text-muted">Candidate information</h6>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <hr>

            {{-- Details --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <div>{{ $career->name }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <div>{{ $career->email }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Mobile:</strong>
                    <div>{{ $career->mobile }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Gender:</strong>
                    <div>{{ ucfirst($career->gender) }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Date of Birth:</strong>
                    <div>{{ $career->dob }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Experience:</strong>
                    <div>{{ $career->experience }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Qualification:</strong>
                    <div>{{ $career->qualification }}</div>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>Message / Details:</strong>
                    <div class="border rounded p-2 bg-white">
                        {{ $career->message ?? '—' }}
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>CV / Resume:</strong>
                    <div class="mt-2">
                        @if($career->cv)
                            <a href="{{ asset('storage/'.$career->cv) }}"
                               class="btn btn-primary btn-sm"
                               download>
                                <i class="fa fa-download"></i> Download CV
                            </a>

                            <a href="{{ asset('storage/'.$career->cv) }}"
                               target="_blank"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-eye"></i> View CV
                            </a>
                        @else
                            <span class="text-muted">No CV uploaded</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 text-muted mt-3">
                    <small>
                        Submitted on {{ $career->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection