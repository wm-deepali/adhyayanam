@extends('layouts.app')

@section('title')
    Syllabus
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .card-body table th {
            font-size: 13px;
        }

        .dropdown-menu a {
            font-size: 14px;
        }
    </style>

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Syllabus</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('syllabus.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search by title"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>

                    <!-- Create Button -->
                    @if(\App\Helpers\Helper::canAccess('manage_syllabus_add'))
                        <a href="{{ route('syllabus.create') }}" class="btn btn-primary">
                            &#43; Create Syllabus
                        </a>
                    @endif

                </div>

                <div class="mt-2">@include('layouts.includes.messages')</div>

                <div class="table-responsive-lg mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Date & Time</th>
                                <th scope="col">Type</th>
                                <th scope="col">Title</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Exam Commission</th>
                                <th scope="col">Category</th>
                                <th scope="col">Sub Category</th>
                                <th scope="col">PDF</th>
                                <th scope="col">Status</th>
                                 <th>Added By</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($syllabusList as $res)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $res->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $res->type }}</td>
                                    <td>{{ $res->title }}</td>
                                    <td>{{ $res->subject->name ?? '_' }}</td>
                                    <td>{{ $res->commission->name ?? '_' }}</td>
                                    <td>{{ $res->category->name ?? '_' }}</td>
                                    <td>{{ $res->subcategory->name ?? '_' }}</td>
                                    <td>
                                        @if ($res->pdf)
                                            <a href="{{ asset('storage/' . $res->pdf) }}" target="_blank">
                                                <img height="40px" src="{{ asset('img/pdficon.png') }}" alt="PDF">
                                            </a>
                                        @else
                                            <span class="text-muted">No PDF</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($res->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $res->creator ? $res->creator->name : 'N/A'  }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="actionMenu{{ $res->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $res->id }}">

    {{-- VIEW --}}
    @if(\App\Helpers\Helper::canAccess('manage_syllabus'))
        <li>
            <a class="dropdown-item" href="{{ route('syllabus.show', $res->id) }}">
                <i class="fa fa-eye text-primary me-2"></i> View
            </a>
        </li>
    @endif

    {{-- EDIT --}}
    @if(\App\Helpers\Helper::canAccess('manage_syllabus_edit'))
        <li>
            <a class="dropdown-item" href="{{ route('syllabus.edit', $res->id) }}">
                <i class="fa fa-edit text-primary me-2"></i> Edit
            </a>
        </li>
    @endif

    {{-- DELETE --}}
    @if(\App\Helpers\Helper::canAccess('manage_syllabus_delete'))
        <li>
            <form action="{{ route('syllabus.destroy', $res->id) }}" method="POST"
                  class="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="dropdown-item text-danger delete-btn">
                    <i class="fa fa-trash me-2" style="color:#dc3545!important"></i> Delete
                </button>
            </form>
        </li>
    @endif

</ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">No Syllabus found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will permanently delete the syllabus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection