@extends('layouts.app')

@section('title')
    Syllabus
@endsection

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
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

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title">Syllabus</h5>
                </div>

                @if(\App\Helpers\Helper::canAccess('manage_syllabus_add'))
                    <a href="{{ route('syllabus.create') }}" class="btn btn-primary">
                        &#43; Create Syllabus
                    </a>
                @endif
            </div>

            {{-- Flash Messages --}}
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            {{-- Table --}}
            <div class="table-responsive-lg mt-3">
                <table class="table table-striped" id="syllabusTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Subject</th>
                            <th>Exam Commission</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection

@push('after-scripts')

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $('#syllabusTable').DataTable({

        processing: true,
        serverSide: true,
        paging: true,
        autoWidth: false,
        searchDelay: 300,
        order: [[1, 'desc']],

        ajax: "{{ route('syllabus.index') }}",

        dom: '<"row mb-3"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right ms-2"B>>>tip',

        buttons: [
            { extend: 'copy',  className: 'btn btn-sm btn-secondary' },
            { extend: 'excel', className: 'btn btn-sm btn-secondary' },
            { extend: 'csv',   className: 'btn btn-sm btn-secondary' },
            { extend: 'print', className: 'btn btn-sm btn-secondary' },
            {
                extend: 'colvis',
                className: 'btn btn-sm btn-secondary',
                text: 'Columns'
            }
        ],

        lengthMenu: [10, 25, 50, 100],

        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_at' },
            { data: 'type' },
            { data: 'title' },
            { data: 'subject' },
            { data: 'commission' },
            { data: 'category' },
            { data: 'subcategory' },
            { data: 'pdf', orderable: false, searchable: false },
            { data: 'status', orderable: false, searchable: false },
            { data: 'created_by' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

});
</script>

@endpush
