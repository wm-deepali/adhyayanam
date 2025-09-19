@extends('layouts.app')

@section('title')
SEO
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create SEO</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Create SEO for pages here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('seo.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="page" class="form-label">Page</label>
                    <select name="page" class="form-control" required>
                        <option value="">Select Page</option>
                        @foreach($pages as $page)
                            <option value="{{$page->heading1.' '.$page->heading2??''}}">{{$page->heading1.' '.$page->heading2??''}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('page'))
                        <span class="text-danger text-left">{{ $errors->first('page') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        placeholder="Title"
                        required>
                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        class="form-control"
                        name="description"
                        placeholder="Description"
                        required></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="keywords" class="form-label">Keywords</label>
                    <input
                        type="text"
                        class="form-control"
                        name="keywords"
                        placeholder="Keywords"
                        required>
                    @if ($errors->has('keywords'))
                        <span class="text-danger text-left">{{ $errors->first('keywords') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="canonical" class="form-label">Canonical URL</label>
                    <input
                        type="text"
                        class="form-control"
                        name="canonical"
                        placeholder="Canonical URL"
                        required>
                    @if ($errors->has('canonical'))
                        <span class="text-danger text-left">{{ $errors->first('canonical') }}</span>
                    @endif
                </div>
            
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('seo.index')}}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection