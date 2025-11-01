@extends('layouts.teacher-app')

@section('title')
    Pending Questions
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Pending Questions</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Manage all pending questions here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <a href='{{route('teacher.question.bank.index')}}' class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Question</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Instructions</th>
                            <th scope="col">Status</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questionBanks as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{$data->created_at}}</td>
                                <td>{!! $data->question !!}</td>
                                <td>{{$data->topics->name ?? "_"}}</td>
                                <td>{{$data->subject->name ?? "-"}}</td>
                                <td>{{$data->instruction}}</td>
                                <td>
                                    @if($data->status === 'Pending')
                                        <span class="badge bg-warning text-light">Pending</span>
                                    @elseif($data->status === 'resubmitted')
                                        <span class="badge bg-info text-light">Resubmitted</span>
                                    @endif
                                </td>

                                <td>{{ $data->addedBy->full_name ?? '-' }}<br>{{ $data->addedBy->email ?? '-' }}</td>
                                <td>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('teacher.question.bank.view', $data->id) }}"><i
                                                        class="fas fa-eye"></i> View</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('teacher.question.bank.edit', $data->id) }}"><i
                                                        class="fas fa-edit"></i> Edit</a></li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger deleteBtn"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('teacher.question.bank.delete', $data->id) }}">
                                                    <i class="fas fa-trash"></i> Delete</button>
                                            </li>

                                        </ul>

                                    </div>
                                </td>
                            </tr>


                        @endforeach
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