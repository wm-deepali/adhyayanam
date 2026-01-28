@extends('layouts.app')

@section('title')
    Our Team Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h5 class="card-title mb-0">Our Team</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage your our team section here.
                        </h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        {{-- Add Team --}}
                        @if(\App\Helpers\Helper::canAccess('manage_team_add'))
                            <a href="{{ route('cm.our.team.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add Team
                            </a>
                        @endif

                        {{-- Back --}}
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            ← Back
                        </a>

                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Experience</th>
                            <th scope="col">Education</th>
                            <th>Added By</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><img src="{{ asset('storage/' . $team->profile_image) }}" alt="Uploaded Image"
                                        class="img-thumbnail" style="max-width: 40px; max-height: 40px;border-radius:30px;">
                                </td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->designation ?? "--" }}</td>
                                <td>{{ $team->experience ?? "--" }}</td>
                                <td>{{ $team->education ?? "--" }}</td>
                                <td>{{ $team->creator ? $team->creator->name : 'Super Admin'  }}</td>
                                <td>
                                    @if(
                                            \App\Helpers\Helper::canAccess('manage_team_edit') ||
                                            \App\Helpers\Helper::canAccess('manage_team_delete')
                                        )
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="actionDropdown{{ $team->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $team->id }}">

                                                {{-- EDIT --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_team_edit'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('cm.our.team.edit', $team->id) }}">
                                                            <i class="fa fa-edit me-1"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif


                                                {{-- DELETE --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_blog_delete'))
                                                    <li>
                                                        <form action="{{ route('cm.our.team.delete', $team->id) }}" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this team member?');">
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
                                    @else
                                        <span class="text-muted">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection