@extends('layouts.app')

@section('title')
    Blogs & Articles Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">Blogs & Articles</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage your blog & articles section here.
                        </h6>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        {{-- Search --}}
                        <input type="text" id="blogSearch" class="form-control form-control-sm"
                            placeholder="Search blogs..." style="width: 200px;">

                        {{-- Add Blog --}}
                        @if(\App\Helpers\Helper::canAccess('manage_blog_add'))
                            <a href="{{ route('blog.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Blog
                            </a>
                        @endif

                        {{-- Back --}}
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            ← Back
                        </a>

                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="container mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col" width="15%">Heading</th>
                                <th scope="col">Short Description</th>
                                <th scope="col">Description</th>
                                <th scope="col" width="10%">Type</th>
                                <th scope="col">Image</th>
                                <th scope="col">Thumbnail</th>
                                <th>Added By</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <th scope="row">
                                        {{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration }}
                                    </th>
                                    <td>{{ $blog->heading }}</td>
                                    <td>{{ $blog->short_description ?? '--' }}</td>
                                    <td>{{ Str::limit(strip_tags($blog->description), 50) }}</td>
                                    <td>{{ $blog->type }}</td>
                                    <td><img src="{{ asset('storage/' . $blog->image) }}" alt="Image" width="50"></td>
                                    <td><img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail" width="50"></td>
                                    <td>{{ $blog->user ? $blog->user->name : 'N/A'  }}</td>
                                    <td>
                                        @if(
                                                \App\Helpers\Helper::canAccess('manage_blog_edit') ||
                                                \App\Helpers\Helper::canAccess('manage_blog_delete')
                                            )
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="actionDropdown{{ $blog->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>

                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $blog->id }}">

                                                    {{-- VIEW --}}
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('blog.show', $blog->id) }}">
                                                            <i class="fa fa-eye me-1"></i> View
                                                        </a>
                                                    </li>

                                                    {{-- EDIT --}}
                                                    @if(\App\Helpers\Helper::canAccess('manage_blog_edit'))
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('blog.edit', $blog->id) }}">
                                                                <i class="fa fa-edit me-1"></i> Edit
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- DELETE --}}
                                                    @if(\App\Helpers\Helper::canAccess('manage_blog_delete'))
                                                        <li>
                                                            <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fa fa-trash me-1" style="color:#dc3545!important"></i>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        @else
                                            <span class="text-muted">No Action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('blogSearch').addEventListener('keyup', function () {
            let value = this.value.toLowerCase();
            document.querySelectorAll("table tbody tr").forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
            });
        });
    </script>
@endsection