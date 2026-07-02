@extends('layouts.app')

@section('title')
    Create | Batch Marquee
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Create Batch Marquee</h5>
                    <h6 class="card-subtitle text-muted">
                        Add Batch Marquee here.
                    </h6>
                </div>

                <div>
                    <a href="{{ route('batch-marquee.index') }}" class="btn btn-secondary">
                        ← Back
                    </a>
                </div>
            </div>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form method="POST" action="{{ route('batch-marquee.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Marquee Content *</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection