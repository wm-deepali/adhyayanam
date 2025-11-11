@extends('layouts.app')

@section('title')
    Question Bank
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .card-body table th {
            font-size: 13px;
        }
    </style>

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Test Paper</h5>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="table-responsive-lg">
                    <table class="table table-striped mt-5">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Date & Time</th>
                                <th scope="col">Paper Name</th>
                                <th scope="col">Test Info</th>
                                <th scope="col">Year</th>
                                <th scope="col">Commission/ Cat / Sub Cat</th>
                                <th scope="col">Total Questions</th>
                                <th scope="col">Total Marks/<br />Durations</th>
                                <th scope="col">PDF</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($test as $res)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $res->created_at }}</td>
                                    <td>{{ $res->name }}<br /><span
                                            class="badge badge-success">{{ $res->test_code ?? "" }}</span></td>
                                    <td>{{ $res->test_paper_type ?? "" }}</td>
                                    <td>{{ $res->previous_year }}</td>
                                    <td>
                                        {{ $res->commission->name ?? "_" }} <br />
                                        {{ $res->category->name ?? "_" }}<br />
                                        <span class="text-success">{{ $res->subcategory->name ?? "_" }}</span>
                                    </td>
                                    <td>{{ $res->total_questions }}</td>
                                    <td>{{ $res->total_marks }}<br />
                                        <span class="badge badge-secondary">{{ $res->duration ?? "" }} mins</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('test-papers.download', $res->id) }}" target="_blank">
                                            <img height="80px" src="{{ asset('img/pdficon.png') }}" />
                                        </a>

                                    </td>
                                    <td>Active</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('test.paper.view', $res->id) }}">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('test.paper.edit', $res->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('test.paper.delete', $res->id) }}" method="POST"
                                                        class="delete-form" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger delete-btn">
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

    {{-- SweetAlert2 confirmation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This test paper will be permanently deleted!",
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