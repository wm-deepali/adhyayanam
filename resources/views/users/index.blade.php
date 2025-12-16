@extends('layouts.app')

@section('title')
    User List
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <h6 class="card-subtitle mb-2 text-muted">Manage your users here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mb-2 text-end">
                    @if(\App\Helpers\Helper::canAccess('manage_users_add'))
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">
                            Add user
                        </a>
                    @endif
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Username</th>
                            <th scope="col">Roles</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                            id="actionDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $user->id }}">
                                            @if(\App\Helpers\Helper::canAccess('manage_users'))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                                        <i class="fa fa-eye me-1 text-info"></i> View
                                                    </a>
                                                </li>
                                            @endif

                                            @if(\App\Helpers\Helper::canAccess('manage_users_edit'))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                        <i class="fa fa-edit me-1 text-primary"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(\App\Helpers\Helper::canAccess('manage_users_delete'))
                                                <li>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-trash me-1" style="color:#dc3545!important"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex">
                    {!! $users->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection