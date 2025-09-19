@extends('layouts.app')

@section('title')
Privacy Policy Management
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Privacy Policy</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage your privacy policy section here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <form id="privacy-form" method="POST" action="{{ route('privacy.policies.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="heading1" class="form-label">Heading</label>
                        <input value="{{ $privacy->heading1 ?? ""}}" 
                            type="text" 
                            class="form-control" 
                            name="heading1" 
                            placeholder="Heading" required>
                
                        @if ($errors->has('heading1'))
                            <span class="text-danger text-left">{{ $errors->first('heading1') }}</span>
                        @endif
                    </div>
                
                    <div class="mb-3">
                        <label for="description1" class="form-label">Description</label>
                        <textarea id="editor" name="description1" style="height: 300px;">{!!$privacy->description1!!}</textarea>
                        @if ($errors->has('description1'))
                            <span class="text-danger text-left">{{ $errors->first('description1') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Save Page</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
         CKEDITOR.replace('editor');
    });
</script>
@endsection