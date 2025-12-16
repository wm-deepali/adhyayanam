@extends('layouts.app')

@section('title')
Adhyayanam | Current Affairs Categories
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Categories</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Categories here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
               @if(\App\Helpers\Helper::canAccess('manage_ca_categories_add'))
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addTopicModal">
                        Add Categories
                    </button>
                @endif

                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Category Name</th>
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
                            <td>{{ $topic->created_at->format('d M Y, h:i A') }}</td>
                            <td>
    @if(
        \App\Helpers\Helper::canAccess('manage_ca_categories_edit') ||
        \App\Helpers\Helper::canAccess('manage_ca_categories_delete')
    )
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Actions
            </button>

            <ul class="dropdown-menu">

                {{-- EDIT --}}
                @if(\App\Helpers\Helper::canAccess('manage_ca_categories_edit'))
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#editTopicModal{{ $topic->id }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                @endif

                {{-- DELETE --}}
                @if(\App\Helpers\Helper::canAccess('manage_ca_categories_delete'))
                    <li>
                        <form action="{{ route('current.affairs.topic.delete', $topic->id) }}"
                            method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-trash" style="color:#dc3545!important"></i> Delete
                            </button>
                        </form>
                    </li>
                @endif

            </ul>
        </div>
    @endif
</td>
                        </tr>

                        <!-- Edit Modal for this category -->
                        <div class="modal fade" id="editTopicModal{{ $topic->id }}" tabindex="-1"
                            aria-labelledby="editTopicModalLabel{{ $topic->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ route('current.affairs.topic.update', $topic->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="editTopicModalLabel{{ $topic->id }}">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $topic->name }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" required>{{ $topic->description }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                    <h5 class="modal-title" id="addTopicModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
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
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
