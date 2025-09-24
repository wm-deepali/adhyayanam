@extends('layouts.app')

@section('title')
    Current Affair List
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Current Affair</h5>
                <h6 class="card-subtitle mb-2 text-muted">Manage Current Affair here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <a href="{{ route('current.affairs.create') }}" class="btn btn-primary">Add New</a>

                    <table class="table table-striped mt-5">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Categories</th>
                                <th scope="col">Title</th>
                                <th scope="col">Short Description</th>
                                <th scope="col">Publishing Date</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Alt Tag</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentAffairs as $affair)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $affair->topic->name ?? "-"}}</td>
                                    <td>{{ $affair->title}}</td>
                                    <td>{{ $affair->short_description}}</td>
                                    <td>{{ $affair->publishing_date}}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $affair->thumbnail_image) }}" alt="Thumbnail"
                                            class="img-thumbnail" style="max-width: 60px; max-height: 60px;">
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $affair->banner_image) }}" alt="Banner"
                                            class="img-thumbnail" style="max-width: 60px; max-height: 60px;">
                                    </td>
                                    <td>{{ $affair->image_alt_tag }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('current.affairs.show', $affair->id) }}">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('current.affairs.edit', $affair->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('current.affairs.delete', $affair->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash" style="color: #dc3545!important"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection