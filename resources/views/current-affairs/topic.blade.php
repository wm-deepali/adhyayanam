@extends('layouts.app')

@section('title')
Topic
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Topic</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Topics here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                    Add Topic
                </button>

                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $topic)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $topic->name }}</td>
                            <td>{{ $topic->description ?? '' }}</td>
                            <td>{{ $topic->created_at }}</td>
                            <td>
                                <form action="{{ route('current.affairs.topic.delete', $topic->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Add Topic Modal -->
<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('current.affairs.topic.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTopicModalLabel">Add Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="Description" required></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
