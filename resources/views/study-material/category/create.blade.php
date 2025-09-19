@extends('layouts.app')

@section('title')
Create|Category
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Create</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Add Category here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                @csrf
                
            
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name"  id="name" placeholder="Name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" required>
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keywords" required>
                    @error('meta_keyword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" placeholder="Meta Description" required></textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="canonical_url" class="form-label">Canonical URL</label>
                    <input type="text" class="form-control" name="canonical_url" id="url" placeholder="Canonical URL" required>
                    @error('canonical_url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*" required>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="alt_tag" class="form-label">Alt Tag</label>
                    <input type="text" class="form-control" name="alt_tag" placeholder="Alt Tag" required>
                    @error('alt_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('category.index')}}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script>
    $(document).ready(function() {
        $(document).on('keyup', "#name", function(event) {
        let title = $(this).val();
        let url = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $("#url").val(url);
        })
    });
</script>
@endpush