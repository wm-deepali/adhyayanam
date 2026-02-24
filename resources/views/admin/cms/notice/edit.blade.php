@extends('layouts.app')
@section('title', 'Edit Notice')

@section('content')
    <div class="card">
        <div class="card-body">

            <h5>Edit Notice</h5>

            <form method="POST" action="{{ route('cm.notice.board.update', $notice->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.cms.notice.form', ['notice' => $notice])

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('cm.notice.board') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>
@endsection