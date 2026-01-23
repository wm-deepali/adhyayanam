@extends('layouts.app')

@section('title')
    Daily Booster
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Daily Booster</h5>
                <h6 class="card-subtitle text-muted">
                    Manage Daily booster section here.
                </h6>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ← Back
                </a>

                @if(\App\Helpers\Helper::canAccess('manage_daily_booster_add'))
                    <a href="{{ route('daily.boost.create') }}" class="btn btn-primary">
                        + Add
                    </a>
                @endif
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <table class="table table-striped mt-4 data-table" id="boosterTable">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" class="group_check checkbox">
                        </th>
                        <th width="15%">Date & Time</th>
                        <th>Thumbnail</th>
                        <th>Video Title</th>
                        <th>Short Description</th>
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

    // DATATABLE INIT
    gb_DataTable = $("#boosterTable").DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        paging: true,
        ajax: "{{ route('daily.boost.index') }}",
        iDisplayLength: 10,
        order: [[1, "DESC"]],
        dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>tip',
        columns: [
            { data: 'checkbox', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'image', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'short_description', name: 'short_description' },
            { data: 'created_by', name: 'created_by' },
            { data: 'action', orderable: false, searchable: false },
        ],
        lengthMenu: [10, 50, 100],
    });

    /* -------------------------------
       DATATABLE SEARCH BUTTON LOGIC
       ------------------------------- */

    // Remove auto-search
    $('#boosterTable_filter input')
        .off()
        .on('keyup', function (e) {
            if (e.keyCode === 13) {
                gb_DataTable.search(this.value).draw();
            }
        });

    // Add Search Button
    $('#boosterTable_filter').append(
        '<button id="dtSearchBtn" class="btn btn-sm btn-primary ms-2">Search</button>'
    );

    // Button triggers search
    $('#dtSearchBtn').on('click', function () {
        let value = $('#boosterTable_filter input').val();
        gb_DataTable.search(value).draw();
    });

});

/* -------------------------------
   BULK DELETE
   ------------------------------- */
function multi_delete() {
    let id = [];
    if (confirm("Are you sure you want to Delete this data?")) {
        $('.career_checkbox:checked').each(function () {
            id.push($(this).attr('id'));
        });

        if (id.length > 0) {
            $.ajax({
                url: "{{ route('booster.bulk-delete') }}",
                method: "get",
                data: { id: id },
                success: function (data) {
                    alert(data);
                    $('#boosterTable').DataTable().ajax.reload();
                }
            });
        } else {
            alert("Please select at least one checkbox");
        }
    }
}

// SELECT ALL
$('.group_check').on('change', function (event) {
    $(".column_checkbox").prop("checked", event.target.checked);
});
</script>
@endpush
