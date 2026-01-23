@extends('layouts.app')

@section('title')
    Upcoming Exams
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Upcoming Exams</h5>
                <h6 class="card-subtitle text-muted">
                    Manage your Upcoming Exams section here.
                </h6>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ← Back
                </a>

                @if(\App\Helpers\Helper::canAccess('manage_upcoming_exams_add'))
                    <a href="{{ route('upcoming.exam.create') }}" class="btn btn-primary">
                        + Add
                    </a>
                @endif
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            @include('layouts.includes.messages')

            <table class="table table-striped mt-4" id="upexam" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" class="group_check checkbox">
                        </th>
                        <th>Date & Time</th>
                        <th>Examination Name</th>
                        <th>Advertisement Date</th>
                        <th>Form Distribution Date</th>
                        <th>Last Date for Submission</th>
                        <th>Exam Date</th>
                        <th>Examination Commission</th>
                        <th>Link</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$(function () {

    gb_DataTable = $("#upexam").DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        paging: true,
        ajax: "{{ route('upcoming.exam.index') }}",
        iDisplayLength: 10,
        order: [[1, "DESC"]],

        // HIDE LESS IMPORTANT COLUMNS
        columnDefs: [
            { targets: [3,4,5], visible: false },
            { targets: 0, orderable: false, searchable: false },
            { targets: -1, orderable: false, searchable: false }
        ],

        columns: [
            { data: 'checkbox' },
            { data: 'created_at' },
            { data: 'examination_name' },
            { data: 'advertisement_date' },
            { data: 'form_distribution_date' },
            { data: 'submission_last_date' },
            { data: 'examination_date' },
            { data: 'commission' },
            { data: 'link' },
            { data: 'created_by' },
            { data: 'action' },
        ],

        lengthMenu: [10, 50, 100],
    });

    // SELECT ALL
    $('.group_check').on('change', function (e) {
        $('.column_checkbox').prop('checked', e.target.checked);
    });

});
</script>
@endpush
