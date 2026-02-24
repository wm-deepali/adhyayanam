@extends('layouts.app')
@section('title', 'Add Notice')

@section('content')
    <div class="card">
        <div class="card-body">

            <h5>Add Notice</h5>

            <form method="POST" action="{{ route('cm.notice.board.store') }}" enctype="multipart/form-data">
                @csrf

                @include('admin.cms.notice.form')

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('cm.notice.board') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>
@endsection