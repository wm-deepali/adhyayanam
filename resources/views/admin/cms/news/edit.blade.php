@extends('layouts.app')
@section('title', 'Edit News')

@section('content')
    <div class="card">
        <div class="card-body">

            <h5>Edit News</h5>

            <form method="POST" action="{{ route('cm.current.news.update', $news->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.cms.news.form', ['news' => $news])

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('cm.current.news') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>
@endsection