@extends('layouts.app')

@section('title', 'Test Paper')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card-body table th {
            font-size: 13px;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107 !important;
        }
    </style>
    <div class="bg-light rounded">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Test Paper</h5>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="#" id="exportTestBtn" class="btn btn-outline-dark">
                            <i class="fa fa-download"></i> Export CSV
                        </a>

                        @if(\App\Helpers\Helper::canAccess('manage_test_bank_add'))
                            <a href="{{ route('test.paper.create') }}" class="btn btn-primary">
                                &#43; Create New Paper
                            </a>
                        @endif

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

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Free / Paid</label>
                                <select class="form-control" id="test_type_filter">
                                    <option value="">--Select--</option>
                                    <option value="free">Free</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Paper Type</label>
                                <select class="form-control" id="paper_category">
                                    <option value="">--Select--</option>
                                    <option value="mcq">MCQ</option>
                                    <option value="subjective">Subjective</option>
                                    <option value="story">Story Based</option>
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
                                <th scope="col">Date & Time</th>

                                <th scope="col">Test Paper Name</th>
                                <th scope="col">Test Info</th>
                                <th scope="col">Cat / Sub Cat</th>
                                <th scope="col">Language/<br />Fee Type</th>
                                <th scope="col">Total Questions</th>
                                <th scope="col">Total Marks/<br />Durations</th>

                                <th scope="col">Status</th>
                                <th scope="col">Added By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="testPaperTableBody">
                            @include('test-paper.table-rows', ["test" => $test])
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $test->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            function fetchData(url = null) {

                let data = {
                    commission_id: $('#exam_com_id').val(),
                    category_id: $('#category_id').val(),
                    sub_category_id: $('#sub_category_id').val(),
                    test_type: $('#test_type').val(),
                    search: $('#search').val(),

                    // ✅ NEW
                    test_type_filter: $('#test_type_filter').val(),
                    paper_category: $('#paper_category').val(),
                };

                $.ajax({
                    url: url ?? "{{ route('test.bank.index') }}",
                    type: "GET",
                    data: data,
                    beforeSend: function () {
                        $('#testPaperTableBody').html('<tr><td colspan="10">Loading...</td></tr>');
                    },
                    success: function (res) {
                        $('#testPaperTableBody').html(res.html);
                        $('.d-flex.justify-content-center.mt-3').html(res.pagination);
                    }
                });
            }

            // FILTER
            $('.filterbtn').click(function () {
                fetchData();
            });

            // RESET
            $('.resetbtn').click(function () {
                $('select, input').val('');
                $('.sub-cat').addClass('hidecls');
                fetchData();
            });

            // PAGINATION
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                fetchData($(this).attr('href'));
            });

        });

        $('#exportTestBtn').click(function (e) {

            e.preventDefault();

            let params = $.param({
                commission_id: $('#exam_com_id').val(),
                category_id: $('#category_id').val(),
                sub_category_id: $('#sub_category_id').val(),
                test_type: $('#test_type').val(),
                test_type_filter: $('#test_type_filter').val(),
                paper_category: $('#paper_category').val(),
                search: $('#search').val()
            });

            window.location.href =
                "{{ route('test.paper.export') }}" + '?' + params;
        });
    </script>

@endsection