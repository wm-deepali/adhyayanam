@extends('layouts.app')

@section('title')
    Teachers
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Teachers</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Manage your teachers here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <a href='{{ route("manage-teachers.create") }}' class="btn btn-primary">&#43; Add Teacher</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <table class="table table-striped table-bordered table-responsive" id="teachersTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="group_check checkbox"></th>
                            <th>Profile Picture</th>
                            <th>Teacher Name</th>
                            <th>Mobile Number</th>
                            <th>Email Id</th>
                            <th>Questions</th>
                            <th>Wallet Balance</th>
                            <th>Total Paid</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ajax populated -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="changePasswordForm" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password for <span id="teacherName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection


@push('after-scripts')
    <script type="text/javascript">
        $(function () {
            var table = $("#teachersTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('manage-teachers.index') }}",
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'profile_picture', name: 'profile_picture', orderable: false, searchable: false },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'mobile_number', name: 'mobile_number' },
                    { data: 'email', name: 'email' },
                    { data: 'total_questions', name: 'total_questions', orderable: false, searchable: false },
                    { data: 'wallet_balance', name: 'wallet_balance', orderable: false, searchable: false },
                    { data: 'total_paid', name: 'total_paid', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[2, 'asc']],
                lengthMenu: [10, 25, 50, 100],
                dom: '<"row mb-2"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right ml-2"B>>>tip',
                buttons: [
                    {
                        className: 'btn btn-danger btn-flat delete_btn pull-left',
                        text: 'Bulk Delete',
                        action: function (e, dt, node, config) {
                            multi_delete();
                        }
                    },
                    { extend: 'excel', className: 'btn btn-info btn-flat', exportOptions: { columns: ':visible:not(:first-child,:last-child)' } },
                    { extend: 'pdf', className: 'btn btn-info btn-flat', exportOptions: { columns: ':visible:not(:first-child,:last-child)' } },
                    { extend: 'csv', className: 'btn btn-info btn-flat', exportOptions: { columns: ':visible:not(:first-child,:last-child)' } },
                    { extend: 'colvis', className: 'btn btn-info btn-flat', text: 'Columns' },
                ],
                columnDefs: [
                    { targets: 0, checkboxes: { selectRow: true } }
                ],
                select: { style: 'multi' },
            });

            // Bulk delete
            function multi_delete() {
                var ids = [];
                $('.column_checkbox:checked').each(function () {
                    ids.push($(this).val());
                });
                if (ids.length === 0) {
                    alert("Please select at least one teacher.");
                    return;
                }
                if (confirm("Are you sure you want to delete selected teachers?")) {
                    $.ajax({
                        url: "{{ route('manage-teachers.bulk-delete') }}",
                        method: "POST",
                        data: { ids: ids, _token: "{{ csrf_token() }}" },
                        success: function (data) {
                            table.ajax.reload();
                            alert(data.message);
                        }
                    });
                }
            }

            // Group checkbox select/deselect
            $('.group_check').on('change', function (event) {
                $(".column_checkbox").prop("checked", event.target.checked);
            });
        });

        $(document).ready(function () {
            var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            var form = $('#changePasswordForm');
            var teacherNameSpan = $('#teacherName');

            // When change password button clicked
            $(document).on('click', '.btn-change-password', function () {
                var teacherId = $(this).data('id');
                var teacherName = $(this).data('name');
                teacherNameSpan.text(teacherName);

                // Change form action dynamically
                form.attr('action', '/manage-teachers/' + teacherId + '/change-password');

                // Reset form fields
                form[0].reset();

                // Show modal
                changePasswordModal.show();
            });

            // Submit form via AJAX
            form.on('submit', function (e) {
                e.preventDefault();

                var actionUrl = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        changePasswordModal.hide();
                        Swal.fire('Success', 'Password updated successfully!', 'success');
                    },
                    error: function (xhr) {
                        var res = xhr.responseJSON;
                        var messages = '';
                        if (res && res.errors) {
                            $.each(res.errors, function (key, value) {
                                messages += value + '<br>';
                            });
                            Swal.fire('Error', messages, 'error');
                        } else {
                            Swal.fire('Error', 'Something went wrong. Try again.', 'error');
                        }
                    }
                });
            });
        });
    </script>

@endpush