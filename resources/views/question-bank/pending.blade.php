@extends('layouts.app')

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
                        <a href='{{route('question.bank.index')}}' class="btn btn-primary">Back</a>
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
                                            <li><a class="dropdown-item" href="{{ route('question.bank.view', $data->id) }}"><i
                                                        class="fas fa-eye"></i> View</a></li>
                                            <li><a class="dropdown-item" href="{{ route('question.bank.edit', $data->id) }}"><i
                                                        class="fas fa-edit"></i> Edit</a></li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger deleteBtn"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('question.bank.delete', $data->id) }}">
                                                    <i class="fas fa-trash"></i> Delete</button>
                                            </li>
                                            <li>
                                                <form action="{{ route('question.bank.update-status', $data->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Done">
                                                    <button type="submit" class="dropdown-item text-success"><i
                                                            class="fas fa-check"></i> Approve</button>
                                                </form>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $data->id }}"><i class="fas fa-times"></i>
                                                    Reject</button>
                                            </li>
                                        </ul>

                                    </div>
                                </td>
                            </tr>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $data->id ?? '' }}" tabindex="-1"
                                aria-labelledby="rejectModalLabel{{ $data->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('question.bank.update-status', $data->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejected">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel{{ $data->id }}">Reject Question
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Reason for Rejection</label>
                                                    <textarea name="note" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Reject</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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