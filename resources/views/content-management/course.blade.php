@extends('layouts.app')

@section('title')
    ADHYAYNAM | E-LEARNING | Courses
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Course</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Manage Course section here.</h6>
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_courses_add'))
                        <div class="justify-content-end">
                            <a href='{{route('courses.course.create')}}' class="btn btn-primary">&#43; Add</a>
                        </div>
                    @endif
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <table class="table table-striped mt-5" id="course">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" class="group_check checkbox">
                            </th>
                            <th scope="col">Image</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Course Mode</th>
                            <th scope="col">Course Type</th>
                            <th scope="col">Exam Category</th>
                            <th scope="col">Sub Category</th>
                            <th scope="col">Type</th>
                            <th scope="col">Course Fee</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Action</th>
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
            gb_DataTable = $("#course").DataTable({
                autoWidth: false,
                order: [0, "ASC"],
                processing: true,
                serverSide: true,
                searchDelay: 2000,
                paging: true,
                ajax: "{{ route('courses.course.index') }}",
                iDisplayLength: "10",
                dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
                buttons: {
                    buttons: [
                        @if(\App\Helpers\Helper::canAccess('manage_courses_delete'))
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
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'course_mode', name: 'course_mode' },
                    { data: 'commission', name: 'commission' },
                    { data: 'category', name: 'category' },
                    { data: 'subcat', name: 'subcat' },
                    { data: 'type', name: 'type' },
                    { data: 'fee', name: 'fee' },
                    { data: 'duration', name: 'duration' },
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
                        url: "{{ route('courses.course.bulk-delete')}}",
                        method: "get",
                        data: { id: id },
                        success: function (data) {
                            alert(data);
                            $('#course').DataTable().ajax.reload();
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