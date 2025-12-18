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
                    <div class="row">
                        <h4 class="form-section">Filter by</h4>

                        {{-- Examination Commission --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Examination Commission</label>
                                <select class="form-control" id="exam_com_id" name="commission_id">
                                    <option value="">--Select--</option>
                                    @foreach($commissions as $commission)
                                        <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                        </div>

                        {{-- Sub Category --}}
                        <div class="col-md-3 sub-cat hidecls">
                            <div class="form-group">
                                <label>Sub Category</label>
                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                        </div>

                        {{-- Test Type --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Test Type</label>
                                <select class="form-control" id="test_type" name="test_type">
                                    <option value="">--Select--</option>
                                    <option value="0">Full Test / Combined Paper</option>
                                    <option value="1">Subject Wise</option>
                                    <option value="2">Chapter Wise</option>
                                    <option value="3">Topic Wise</option>
                                </select>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search</label>
                                <input type="text" id="search" name="search" class="form-control"
                                    placeholder="Search test papers...">
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-md-6" style="margin-top: 25px;">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary filterbtn">Filter Now</button>
                                <button type="button" class="btn btn-danger resetbtn">Reset</button>
                            </div>
                        </div>
                    </div>

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
                                <th scope="col">Added By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="testPaperTableBody">
                            @include('pyq.table-rows', ["test" => $test])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $(document).on('change', '#exam_com_id', function (event) {

                $('#category_id').html("");
                $('#subject_id').html("");
                $('#chapter_id').html("");
                $('#topic_id').html("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html);
                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#category_id', function (event) {

                $('#sub_category_id').html("");
                let exam_category = $(this).val();
                if (exam_category != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#sub_category_id').html(result.html);
                                    $('.sub-cat').removeClass('hidecls');

                                }
                                else {
                                    $('#sub_category_id').val("").trigger('change');
                                    $('.sub-cat').addClass('hidecls');

                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    $('#sub_category_id').val("").trigger('change');
                    $('.sub-cat').addClass('hidecls');

                }

            });

            // 🔹 Filter Now
            $('.filterbtn').on('click', function () {
                let data = {
                    commission_id: $('#exam_com_id').val(),
                    category_id: $('#category_id').val(),
                    sub_category_id: $('#sub_category_id').val(),
                    test_type: $('#test_type').val(),
                    search: $('#search').val(),
                };

                $.ajax({
                    url: "{{ route('pyq.filter') }}",
                    type: "GET",
                    data: data,
                    beforeSend: function () {
                        $('#testPaperTableBody').html(`<tr><td colspan="9" class="text-center">Loading...</td></tr>`);
                    },
                    success: function (response) {
                        $('#testPaperTableBody').html(response.html);
                    },
                    error: function () {
                        $('#testPaperTableBody').html(`<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>`);
                    }
                });
            });

            // 🔹 Reset Filters
            $('.resetbtn').on('click', function () {
                $('#exam_com_id').val('');
                $('#category_id').val('');
                $('#sub_category_id').val('');
                $('#test_type').val('');
                $('#search').val('');
                $('.sub-cat').addClass('hidecls');
                $('.filterbtn').click(); // reload default listing
            });

        });

    </script>
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