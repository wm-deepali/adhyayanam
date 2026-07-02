@extends('layouts.app')

@section('title')
    Edit | Batch Marquee
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Edit Batch Marquee</h5>
                    <h6 class="card-subtitle text-muted">
                        Update Batch Marquee here.
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

            <form method="POST" action="{{ route('batch-marquee.update', $batch_marquee->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Marquee Content *</label>

                    <textarea name="content"
                              id="content"
                              class="form-control"
                              rows="6"
                              required>{!! $batch_marquee->content !!}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-control">
                        <option value="1" {{ $batch_marquee->status ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ !$batch_marquee->status ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
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