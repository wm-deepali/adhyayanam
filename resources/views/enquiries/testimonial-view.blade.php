@extends('layouts.app')

@section('title')
    View Testimonial
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Testimonial</h5>
            <h6 class="card-subtitle mb-2 text-muted"> View Testimonial Request here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <div class="mb-3">
                    <label for="username" class="form-label">Name: </label>
                    {{ $testimonial->username }}
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email: </label>
                    {{ $testimonial->email }}
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile: </label>
                    {{ $testimonial->number }}
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Message: </label>
                    {{ $testimonial->message }}
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status: </label>
                    {{ $testimonial->status }}
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image: </label>
                    <a href='{{ url('uploads/feed-photos/' . $testimonial->photo) }}' download="{{ $testimonial->username }}"><img src="{{ url('uploads/feed-photos/' . $testimonial->photo) }}" alt="Uploaded Image" class="img-thumbnail" style="max-width: 80px; max-height: 80px;border-radius:10px;"></a>
                </div>
                <br/><div class="mb-3">
                @if($testimonial->is_approved == 0)
                <form action="{{ route('testimonial.approveStatus', $testimonial->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Approve</button>
                </form>
                @endif
                <a href="{{ route('testimonials.index') }}" class="btn  btn-secondary">Back</a>
                </div>
                
            </div>

        </div>
    </div>
</div>
@endsection
