@extends('layouts.app')

@section('title')
    View Category
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Category Details</h5>
            <a href="{{ route('current.affairs.topic.index') }}" class="btn btn-secondary">⬅ Back</a>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Name:</strong>
                <p>{{ $topic->name }}</p>
            </div>

            <div class="mb-3">
                <strong>Description:</strong>
                <p>{{ $topic->description }}</p>
            </div>

            <div class="mb-3">
                <strong>Added By:</strong>
                <p>{{ $topic->creator ? $topic->creator->name : 'Super Admin' }}</p>
            </div>

            <div class="mb-3">
                <strong>Created At:</strong>
                <p>{{ $topic->created_at->format('d M Y, h:i A') }}</p>
            </div>

            <div class="mb-3">
                <strong>Total Current Affairs:</strong>
                <p>{{ $topic->currentAffair->count() }}</p>
            </div>

        </div>
    </div>
</div>
@endsection