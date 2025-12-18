@extends('layouts.app')

@section('title')
    Blogs & Articles Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Blogs & Articles</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage your blog & articles section here.</h6>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="container mt-4">
                    @if(\App\Helpers\Helper::canAccess('manage_blog_add'))
                        <form method="POST" action="{{ route('blog.store') }}" id="blog-form" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="heading" class="form-label">Heading</label>
                                <input type="text" class="form-control" name="heading" placeholder="Heading" required>
                                @if ($errors->has('heading'))
                                    <span class="text-danger text-left">{{ $errors->first('heading') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <input type="text" class="form-control" name="short_description"
                                    placeholder="Short Description">
                                @if ($errors->has('short_description'))
                                    <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="editor" name="description" style="height: 200px;"></textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" class="form-control" name="type" placeholder="Type">
                                @if ($errors->has('type'))
                                    <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*" required>
                                @if ($errors->has('image'))
                                    <span class="text-danger text-left">{{ $errors->first('image') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail" accept="image/*">
                                @if ($errors->has('thumbnail'))
                                    <span class="text-danger text-left">{{ $errors->first('thumbnail') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Save Blog</button>
                    </form>
                    @else
                        <div class="alert alert-warning">You don’t have permission to add blogs.</div>
                    @endif

                    <table class="table table-striped mt-5">
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
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $blog->heading }}</td>
                                    <td>{{ $blog->short_description ?? '--' }}</td>
                                    <td>{{ Str::limit($blog->description, 50) }}</td>
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
                                                                    <i class="fa fa-trash me-1" style="color:#dc3545!important"></i> Delete
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
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor');
        });
    </script>
@endsection