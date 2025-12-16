@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Role Groups</h5>
            @if(\App\Helpers\Helper::canAccess('manage_role_groups_add'))
                <a href="{{ route('role-groups.create') }}" class="btn btn-primary">Create Role Group</a>
            @endif
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Group Name</th>
                        <!-- <th>Type</th> -->
                        <th>Total Permissions</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $group->name }}</td>
                            <!-- <td>{{ $group->type ?? '-' }}</td> -->
                            <td>{{ is_array($group->permissions) ? count($group->permissions) : 0 }}</td>

                            <td>
                                @if(\App\Helpers\Helper::canAccess('manage_role_groups_edit'))
                                    <a href="{{ route('role-groups.edit', $group->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                @endif

                                @if(\App\Helpers\Helper::canAccess('manage_role_groups_delete'))
                                    <form action="{{ route('role-groups.destroy', $group->id) }}" method="POST"
                                        style="display:inline-block;" onsubmit="return confirm('Delete this role group?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Role Groups Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
@endsection