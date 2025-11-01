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
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="teacherFilter">Filter by Teacher</label>
                        <select id="teacherFilter" class="form-control">
                            <option value="">-- All --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name ?? $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="question-container">
                    @include('question-bank.pending-question-table')
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('teacherFilter').addEventListener('change', function () {
                console.log('filter changed');

                const teacherId = this.value;
                $.ajax({
                    url: `{{ route('question.bank.pending') }}?teacher_id=${teacherId}`,
                    type: "get",
                    datatype: "html"
                }).done(function (data) {
                    $("#question-container").empty().html(data);
                }).fail(function (jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
            
            });
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