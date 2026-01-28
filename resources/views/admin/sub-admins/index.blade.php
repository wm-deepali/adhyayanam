@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sub Admins</h5>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>

                @if(\App\Helpers\Helper::canAccess('manage_sub_admins_add'))
                    <a href="{{ route('sub-admins.create') }}" class="btn btn-primary btn-sm">
                        Create Sub Admin
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role Group</th>
                        <th>Added By</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile ?? '-' }}</td>
                            <td>{{ $user->roleGroup->name ?? '-' }}</td>
                            <td>{{ $user->creator ? $user->creator->name : 'Super Admin'  }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Actions
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        {{-- VIEW --}}
                                        <li>
                                            <a href="{{ route('sub-admins.show', $user->id) }}" class="dropdown-item">
                                                <i class="fa fa-eye me-1 text-info"></i>
                                                View
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        {{-- Update Password --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_sub_admins_update_password'))
                                            <li>
                                                <a href="{{ route('sub-admins.password.edit', $user->id) }}" class="dropdown-item">
                                                    <i class="fa fa-key me-1 text-warning"></i>
                                                    Update Password
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Edit --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_sub_admins_edit'))
                                            <li>
                                                <a href="{{ route('sub-admins.edit', $user->id) }}" class="dropdown-item">
                                                    <i class="fa fa-edit me-1 text-primary"></i>
                                                    Edit
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Delete --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_sub_admins_delete'))
                                            <li>
                                                <form action="{{ route('sub-admins.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this Sub Admin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-1" style="color:#dc3545!important"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No Sub Admins Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection