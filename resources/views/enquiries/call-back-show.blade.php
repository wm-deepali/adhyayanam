@extends('layouts.app')

@section('title')
    View Call Back Request
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Call Back Request</h5>
                    <h6 class="card-subtitle text-muted">
                        View request details
                    </h6>
                </div>

                <a href="{{ route('enquiries.call.request') ?? url()->previous() }}"
                   class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="25%">Query For</th>
                            <td>{{ $callback->query_for ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Full Name</th>
                            <td>{{ $callback->full_name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td>{{ $callback->mobile ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $callback->email ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $callback->created_at->format('d M Y, h:i A') }}</td>
                        </tr>

                        @if(!empty($callback->message))
                        <tr>
                            <th>Message</th>
                            <td>{{ $callback->message }}</td>
                        </tr>
                        @endif

                        @if(!empty($callback->file))
                        <tr>
                            <th>Attachment</th>
                            <td>
                                <a href="{{ asset('storage/'.$callback->file) }}"
                                   class="btn btn-sm btn-primary"
                                   download>
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection