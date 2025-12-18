@extends('layouts.app')

@section('title')
    Upcoming Exams
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Upcoming Exams</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Manage your Upcoming Exams section here.</h6>
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_upcoming_exams_add'))
                        <div class="justify-content-end">
                            <a href='{{route('upcoming.exam.create')}}' class="btn btn-primary">&#43; Add</a>
                        </div>
                    @endif
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <table class="table table-striped mt-5" id="upexam">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" class="group_check checkbox">
                            </th>
                            <th scope="col" width="15%">Date & Time</th>
                            <th scope="col">Examination Name</th>
                            <th scope="col">Advertisement Date</th>
                            <th scope="col">Form Distribution Date</th>
                            <th scope="col">Last Date for Submission</th>
                            <th scope="col">Exam Date</th>
                            <th scope="col">Examination Commission</th>
                            <th scope="col">Link</th>
                            <th>Added By</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $(function () {
            gb_DataTable = $("#upexam").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('upcoming.exam.index') }}",
                iDisplayLength: "10",
                dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
                buttons: {
                    buttons: [
                        @if(\App\Helpers\Helper::canAccess('manage_upcoming_exams_delete'))
                                        {
                                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                                text: 'Bulk Delete',
                                action: function (e, dt, node, config) {
                                    multi_delete();
                                }
                            },
                        @endif
                        { extend: 'copy', className: 'btn bg-teal color-palette btn-flat', footer: true, exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] } },
                        { extend: 'excel', className: 'btn bg-teal color-palette btn-flat', footer: true, exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] } },
                        { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat', footer: true, exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] } },
                        { extend: 'print', className: 'btn bg-teal color-palette btn-flat', footer: true, exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] } },
                        { extend: 'csv', className: 'btn bg-teal color-palette btn-flat', footer: true, exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] } },
                        { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat', footer: true, text: 'Columns' },

                    ]
                },
                columnDefs: [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                select: {
                    'style': 'multi'
                },

                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'examination_name', name: 'examination_name' },
                    { data: 'advertisement_date', name: 'advertisement_date' },
                    { data: 'form_distribution_date', name: 'form_distribution_date' },
                    { data: 'submission_last_date', name: 'submission_last_date' },
                    { data: 'examination_date', name: 'examination_date' },
                    { data: 'commission', name: 'commission' },
                    { data: 'link', name: 'link' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                lengthMenu: [10, 50, 100],
            });
        });


        function multi_delete() {
            var id = [];
            if (confirm("Are you sure you want to Delete this data?")) {
                $('.career_checkbox:checked').each(function () {
                    id.push($(this).attr('id'));
                });
                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('upcoming.exam.bulk-delete')}}",
                        method: "get",
                        data: { id: id },
                        success: function (data) {
                            alert(data);
                            $('#upexam').DataTable().ajax.reload();
                        }
                    });
                }
                else {
                    alert("Please select atleast one checkbox");
                }
            }
        }
    </script>


    <script type="text/javascript">

        $('.group_check').on('change', function (event) {
            if (event.target.checked) {
                $(".column_checkbox").prop("checked", true);
            }
            else {
                $(".column_checkbox").prop("checked", false);
            }
        });

    </script>
@endpush