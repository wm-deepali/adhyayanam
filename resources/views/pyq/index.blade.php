@extends('layouts.app')

@section('title', 'Question Bank')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .card-body table th {
        font-size: 13px;
    }
    .hidecls {
        display: none;
    }
</style>

<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Test Paper</h5>

                {{-- BACK BUTTON --}}
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ⬅ Back
                </a>
            </div>

            {{-- FLASH MESSAGES --}}
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            {{-- FILTER SECTION --}}
            <div class="row mt-4">
                <h4 class="form-section">Filter by</h4>

                {{-- Examination Commission --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Examination Commission</label>
                        <select class="form-control" id="exam_com_id">
                            <option value="">-- Select --</option>
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
                        <select class="form-control" id="category_id">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                </div>

                {{-- Sub Category --}}
                <div class="col-md-3 sub-cat hidecls">
                    <div class="form-group">
                        <label>Sub Category</label>
                        <select class="form-control" id="sub_category_id">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                </div>

                {{-- Test Type --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Test Type</label>
                        <select class="form-control" id="test_type">
                            <option value="">-- Select --</option>
                            <option value="0">Full / Combined</option>
                            <option value="1">Subject Wise</option>
                            <option value="2">Chapter Wise</option>
                            <option value="3">Topic Wise</option>
                        </select>
                    </div>
                </div>

                {{-- Search --}}
                <div class="col-md-3 mt-2">
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text"
                               id="search"
                               class="form-control"
                               placeholder="Search by name, code, category...">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-md-6 mt-4">
                    <button type="button" class="btn btn-primary filterbtn">Filter Now</button>
                    <button type="button" class="btn btn-danger resetbtn">Reset</button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive-lg mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Paper Name</th>
                            <th>Test Info</th>
                            <th>Year</th>
                            <th>Commission / Cat / Sub Cat</th>
                            <th>Total Questions</th>
                            <th>Total Marks / Duration</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="testPaperTableBody">
                        @include('pyq.table-rows', ['test' => $test])
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- JQUERY --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // Fetch categories by commission
    $('#exam_com_id').on('change', function () {
        let id = $(this).val();
        $('#category_id').html('<option value="">-- Select --</option>');
        $('#sub_category_id').html('');
        $('.sub-cat').addClass('hidecls');

        if (!id) return;

        $.get(`{{ url('fetch-exam-category-by-commission') }}/${id}`, function (res) {
            if (res.success) {
                $('#category_id').html(res.html);
            }
        });
    });

    // Fetch sub categories
    $('#category_id').on('change', function () {
        let id = $(this).val();
        $('#sub_category_id').html('');
        $('.sub-cat').addClass('hidecls');

        if (!id) return;

        $.get(`{{ url('fetch-sub-category-by-exam-category') }}/${id}`, function (res) {
            if (res.success && res.html !== '') {
                $('#sub_category_id').html(res.html);
                $('.sub-cat').removeClass('hidecls');
            }
        });
    });

    // FILTER
    $('.filterbtn').on('click', function () {
        $.ajax({
            url: "{{ route('pyq.filter') }}",
            type: "GET",
            data: {
                commission_id: $('#exam_com_id').val(),
                category_id: $('#category_id').val(),
                sub_category_id: $('#sub_category_id').val(),
                test_type: $('#test_type').val(),
                search: $('#search').val(),
            },
            beforeSend: function () {
                $('#testPaperTableBody')
                    .html('<tr><td colspan="12" class="text-center">Loading...</td></tr>');
            },
            success: function (res) {
                $('#testPaperTableBody').html(res.html);
            },
            error: function () {
                $('#testPaperTableBody')
                    .html('<tr><td colspan="12" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    });

    // RESET
    $('.resetbtn').on('click', function () {
        $('#exam_com_id, #category_id, #sub_category_id, #test_type, #search').val('');
        $('.sub-cat').addClass('hidecls');
        $('.filterbtn').trigger('click');
    });

});
</script>

@endsection
