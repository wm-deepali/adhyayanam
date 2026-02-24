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
                    <small class="text-muted">
                        View {{ strtolower($pageTitle) }} information
                    </small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tbody>

                        {{-- NAME --}}
                        <tr>
                            <th width="25%">Name</th>
                            <td>{{ $feed->username }}</td>
                        </tr>

                        {{-- DESIGNATION --}}
                        <tr>
                            <th>Designation</th>
                            <td>{{ $feed->designation ?? 'Student' }}</td>
                        </tr>

                        {{-- EMAIL --}}
                        <tr>
                            <th>Email</th>
                            <td>{{ $feed->email }}</td>
                        </tr>

                        {{-- MOBILE --}}
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $feed->number }}</td>
                        </tr>

                        {{-- STATUS --}}
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $feed->status_label }}
                                </span>
                            </td>
                        </tr>

                        {{-- ⭐ RATING (ONLY FOR TESTIMONIAL) --}}
                        @if($feed->type == 2)
                        <tr>
                            <th>Rating</th>
                            <td>
                                @if($feed->rating)
                                    <span style="color:#FFC107; font-size:18px;">
                                        {!! str_repeat('★', $feed->rating) !!}
                                    </span>
                                    <span class="text-muted">
                                        {!! str_repeat('☆', 5 - $feed->rating) !!}
                                    </span>
                                @else
                                    <span class="text-muted">Not Rated</span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        {{-- MESSAGE --}}
                        <tr>
                            <th>Message</th>
                            <td style="white-space: pre-line;">
                                {{ $feed->message }}
                            </td>
                        </tr>

                        {{-- PHOTO --}}
                        <tr>
                            <th>Photo</th>
                            <td>
                                @if($feed->photo)
                                    <img src="{{ url('uploads/feed-photos/'.$feed->photo) }}"
                                         class="img-thumbnail"
                                         style="max-width:160px;border-radius:10px;">
                                @else
                                    <span class="text-muted">No image uploaded</span>
                                @endif
                            </td>
                        </tr>

                        {{-- CREATED DATE --}}
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