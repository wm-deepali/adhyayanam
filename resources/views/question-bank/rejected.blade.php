@extends('layouts.app')

@section('title')
    Question Bank
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Question Bank</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Manage your Question Bank section here.
                        </h6>
                    </div>
                    <div class="justify-content-end">
                        <a href="{{ route('question.bank.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <table class="table table-striped mt-5 align-middle">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Question</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Instructions</th>
                            <th scope="col">Status</th>
                            <th scope="col">Rejected by</th>
                            <th scope="col">Reason</th>
                            <th scope="col" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questionBanks as $data)
                            <tr id="row-{{ $data->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->created_at }}</td>
                                <td>{!! $data->question !!}</td>
                                <td>{{ $data->topics->name ?? "_" }}</td>
                                <td>{{ $data->subject->name ?? "-" }}</td>
                                <td>{{ $data->instruction }}</td>
                                <td><span class="badge bg-danger">{{ ucfirst($data->status) }}</span></td>
                                <td>
                                    {{ $data->rejectedBy->name ?? '-' }}
                                </td>
                                <td>{{ $data->note }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                            <li><a class="dropdown-item text-primary"
                                                    href="{{route('question.bank.view', $data->id)}}">View</a></li>
                                            <li><a class="dropdown-item text-secondary"
                                                    href="{{ route('question.bank.edit', $data->id) }}">Edit</a></li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger deleteBtn"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('question.bank.delete', $data->id) }}">
                                                    Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $questionBanks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This question will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(url, {
                                data: {
                                    _token: '{{ csrf_token() }}'
                                }
                            })
                                .then(response => {
                                    // Remove the deleted row from the DOM
                                    document.getElementById('row-' + id).remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'The question has been deleted successfully.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                })
                                .catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops!',
                                        text: 'Something went wrong while deleting the question.'
                                    });
                                    console.error(error);
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection