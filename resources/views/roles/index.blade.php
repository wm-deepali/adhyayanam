@extends('layouts.app')

@section('title')
    Role list
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Roles</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage your roles here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mb-2 text-end">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Add role</a>
                </div>

                <table class="table table-striped">
                    <tr>
                        <th width="1%">No</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $perm)
                                    <span class="badge text-bg-info">{{ $perm->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                        id="actionMenu{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $role->id }}">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('roles.show', $role->id) }}">
                                                <i class="fa fa-eye text-primary me-2"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
                                                <i class="fa fa-edit text-success me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>


                <div class="d-flex">
                    {!! $roles->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection