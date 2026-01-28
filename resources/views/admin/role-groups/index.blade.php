@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Role Groups</h5>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ← Back
                </a>

                @if(\App\Helpers\Helper::canAccess('manage_role_groups_add'))
                    <a href="{{ route('role-groups.create') }}" class="btn btn-primary">
                        Create Role Group
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Total Permissions</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>
                                {{ ($groups->currentPage() - 1) * $groups->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $group->name }}</td>
                            <td>{{ count($group->permissions ?? []) }}</td>
                            <td>{{ $group->creator->name ?? 'Super Admin' }}</td>

                            {{-- STATUS --}}
                            <td>
                                @if($group->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($group->status === 'pending_approval')
                                    <span class="badge bg-warning">Pending Approval</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        {{-- VIEW --}}
                                        <li>
                                            <a class="dropdown-item" href="{{ route('role-groups.show', $group->id) }}">
                                                <i class="fa fa-eye me-2"></i> View
                                            </a>
                                        </li>

                                        {{-- EDIT --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_role_groups_edit'))
                                            <li>
                                                <a class="dropdown-item" href="{{ route('role-groups.edit', $group->id) }}">
                                                    <i class="fa fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                        @endif

                                        {{-- DELETE --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_role_groups_delete'))
                                            <li>
                                                <form action="{{ route('role-groups.destroy', $group->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this role group?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2" style="color:#dc3545!important"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        {{-- ADMIN APPROVE --}}
                                        @if(auth()->user()->type === 'admin' && $group->status === 'pending_approval')
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('role-groups.approve', $group->id) }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="fa fa-check me-2"></i> Approve
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
                            <td colspan="6" class="text-center">
                                No Role Groups Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $groups->links() }}
        </div>
    </div>
@endsection