@extends('layouts.app')

@php
    $pageTitle = $feed->type == 2 ? 'Testimonial' : 'Feedback';
@endphp

@section('title', 'View '.$pageTitle)

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">{{ $pageTitle }} Details</h5>
                    <small class="text-muted">View {{ strtolower($pageTitle) }} information</small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr><th width="25%">Name</th><td>{{ $feed->username }}</td></tr>
                        <tr><th>Email</th><td>{{ $feed->email }}</td></tr>
                        <tr><th>Mobile</th><td>{{ $feed->number }}</td></tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $feed->status_label }}
                                </span>
                            </td>
                        </tr>

                        <tr><th>Message</th><td>{{ $feed->message }}</td></tr>

                        <tr>
                            <th>Photo</th>
                            <td>
                                @if($feed->photo)
                                    <img src="{{ url('uploads/feed-photos/'.$feed->photo) }}"
                                         class="img-thumbnail"
                                         style="max-width:150px;border-radius:10px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $feed->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection