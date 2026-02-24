@extends('layouts.app')
@section('title', 'Current News')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5>Current News</h5>
                <a href="{{ route('cm.current.news.create') }}" class="btn btn-primary">
                    + Add News
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
                    @foreach($news as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ ucfirst($item->type) }}</td>
                            <td>
                                <a href="{{ route('cm.current.news.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>

                                <form method="POST" action="{{ route('cm.current.news.delete', $item->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $news->links() }}

        </div>
    </div>
@endsection