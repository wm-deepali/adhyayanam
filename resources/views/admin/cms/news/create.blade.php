@extends('layouts.app')
@section('title', 'Add News')

@section('content')
    <div class="card">
        <div class="card-body">

            <h5>Add News</h5>

            <form method="POST" action="{{ route('cm.current.news.store') }}" enctype="multipart/form-data">
                @csrf

                @include('admin.cms.news.form')

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('cm.current.news') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>
@endsection