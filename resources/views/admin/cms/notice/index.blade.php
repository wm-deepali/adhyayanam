@extends('layouts.app')
@section('title', 'Notice Board')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5>Notice Board</h5>
                <a href="{{ route('cm.notice.board.create') }}" class="btn btn-primary">
                    + Add Notice
                </a>
            </div>

            @include('layouts.includes.messages')

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $notice)
                        <tr>
                            <td>{{ $notice->title }}</td>
                            <td>{{ ucfirst($notice->type) }}</td>
                            <td>
                                <a href="{{ route('cm.notice.board.edit', $notice->id) }}" class="btn btn-info btn-sm">Edit</a>

                                <form method="POST" action="{{ route('cm.notice.board.delete', $notice->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $notices->links() }}

        </div>
    </div>
@endsection