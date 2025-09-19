@extends('layouts.app')

@section('title')
Create|Course Type
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Create</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Add Course Type Commission here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('cm.exam.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" placeholder="Description"></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                    @if ($errors->has('meta_title'))
                        <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                    <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keyword">
                    @if ($errors->has('meta_keyword'))
                        <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" placeholder="Meta Description"></textarea>
                    @if ($errors->has('meta_description'))
                        <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="canonical_url" class="form-label">Canonical URL</label>
                    <input type="url" class="form-control" name="canonical_url" placeholder="Canonical URL">
                    @if ($errors->has('canonical_url'))
                        <span class="text-danger text-left">{{ $errors->first('canonical_url') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image">
                    @if ($errors->has('image'))
                        <span class="text-danger text-left">{{ $errors->first('image') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="alt_tag" class="form-label">Alt Tag</label>
                    <input type="text" class="form-control" name="alt_tag" placeholder="Alt Tag">
                    @if ($errors->has('alt_tag'))
                        <span class="text-danger text-left">{{ $errors->first('alt_tag') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                    @endif
                </div>
            
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('cm.exam')}}" class="btn">Back</a>
            </form>
            
        </div>
    </div>
</div>
@endsection