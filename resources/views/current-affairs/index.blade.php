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

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Search Box -->
                        <form method="GET" action="{{ route('current.affairs.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-success">Search</button>
                        </form>

                        @if(\App\Helpers\Helper::canAccess('manage_ca_add'))
                            <a href="{{ route('current.affairs.create') }}" class="btn btn-primary">
                                Add New
                            </a>
                        @endif

                    </div>

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
                                        @if(
                                                \App\Helpers\Helper::canAccess('manage_ca_edit') ||
                                                \App\Helpers\Helper::canAccess('manage_ca_delete')
                                            )
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>

                                                <ul class="dropdown-menu">

                                                    {{-- VIEW (usually allowed with manage) --}}
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('current.affairs.show', $affair->id) }}">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </li>

                                                    {{-- EDIT --}}
                                                    @if(\App\Helpers\Helper::canAccess('manage_ca_edit'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('current.affairs.edit', $affair->id) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- DELETE --}}
                                                    @if(\App\Helpers\Helper::canAccess('manage_ca_delete'))
                                                        <li>
                                                            <form action="{{ route('current.affairs.delete', $affair->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this current affair?');">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection