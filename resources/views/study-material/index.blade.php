@extends('layouts.app')

@section('title')
    Adhayaynam | Study Material
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <div class="col">
                    <h5 class="card-title">Study Material</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Manage your Study Material section here.
                    </h6>
                </div>

                @if(\App\Helpers\Helper::canAccess('manage_study_material_add'))
                    <div class="justify-content-end">
                        <a href="{{ route('study.material.create') }}" class="btn btn-primary">
                            + Add
                        </a>
                    </div>
                @endif
            </div>

            @include('layouts.includes.messages')

            {{-- Tabs --}}
            <ul class="nav nav-tabs" id="studyMaterialTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="free-tab" data-bs-toggle="tab"
                        data-bs-target="#free" type="button">
                        Free
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="paid-tab" data-bs-toggle="tab"
                        data-bs-target="#paid" type="button">
                        Paid
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4">

                {{-- FREE --}}
                <div class="tab-pane fade show active" id="free">
                    <table class="table table-bordered table-striped" id="freeMaterial">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="group_check"></th>
                            <th>Date & Time</th>
                            <th>Title</th>
                            <th>Examination Detail</th>
                            <th>Payment Type</th>
                            <th>Package Type</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                {{-- PAID --}}
                <div class="tab-pane fade" id="paid">
                    <table class="table table-bordered table-striped" id="paidMaterial">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="group_check"></th>
                            <th>Date & Time</th>
                            <th>Title</th>
                            <th>Examination Detail</th>
                            <th>Payment Type</th>
                            <th>Package Type</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
let freeTable, paidTable;

$(document).ready(function () {

    /* ================= FREE TABLE ================= */
    freeTable = $('#freeMaterial').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('study.material.index') }}",
            data: { type: 0 }
        },
        columns: [
            { data: 'checkbox', orderable:false, searchable:false },
            { data: 'created_at' },
            { data: 'title' },
            { data: 'examination_detail' },
            { data: 'payment_type' },
            { data: 'package_type' },
            { data: 'status', orderable:false },
            { data: 'created_by' },
            { data: 'action', orderable:false, searchable:false },
        ],
        order: [[1, 'desc']],
        lengthMenu: [10, 50, 100],
    });

    /* ================= PAID TABLE (INIT ONCE) ================= */
    $('#paid-tab').on('shown.bs.tab', function () {

        if (!$.fn.DataTable.isDataTable('#paidMaterial')) {

            paidTable = $('#paidMaterial').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('study.material.index') }}",
                    data: { type: 1 }
                },
                columns: [
                    { data: 'checkbox', orderable:false, searchable:false },
                    { data: 'created_at' },
                    { data: 'title' },
                    { data: 'examination_detail' },
                    { data: 'payment_type' },
                    { data: 'package_type' },
                    { data: 'status', orderable:false },
                    { data: 'created_by' },
                    { data: 'action', orderable:false, searchable:false },
                ],
                order: [[1, 'desc']],
                lengthMenu: [10, 50, 100],
            });

        } else {
            paidTable.ajax.reload();
        }
    });

});

/* ================= GROUP CHECKBOX ================= */
$(document).on('change', '.group_check', function () {
    $('.column_checkbox').prop('checked', this.checked);
});

/* ================= BULK DELETE ================= */
function multi_delete() {
    let ids = [];
    $('.career_checkbox:checked').each(function () {
        ids.push($(this).attr('id'));
    });

    if (!ids.length) {
        alert('Please select at least one record');
        return;
    }

    if (!confirm('Are you sure you want to delete selected items?')) return;

    $.ajax({
        url: "{{ route('study.material.bulk-delete') }}",
        method: "GET",
        data: { id: ids },
        success: function (response) {
            freeTable.ajax.reload();
            if (paidTable) paidTable.ajax.reload();
            alert(response);
        }
    });
}
</script>
@endpush
