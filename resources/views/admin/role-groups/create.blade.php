@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Create Role Group</h5>
    </div>

    <form action="{{ route('role-groups.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <div class="mb-3">
                <label>Role Group Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- <div class="mb-3">
                <label>Role Type</label>
                <select name="type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Academic">Academic</option>
                    <option value="Universities">Universities</option>
                    <option value="Competitive">Competitive</option>
                </select>
            </div> -->

            <h5 class="mt-4 mb-3">Permissions</h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="250">Module</th>
                            <th width="80">Manage</th>
                            <th width="80">Add</th>
                            <th width="80">Edit</th>
                            <th width="80">Status</th>
                            <th width="80">Delete</th>
                            <th width="120">Extra</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $groups = config('admin_permissions');
                        @endphp

                        @foreach($groups as $groupName => $modules)

                            {{-- GROUP HEADER --}}
                            <tr class="group-header bg-light fw-bold" style="cursor: pointer;"
                                data-group="{{ Str::slug($groupName) }}">
                                <td colspan="7">
                                    <span class="toggle-icon me-2">➕</span> {{ $groupName }}
                                </td>
                            </tr>

                            {{-- GROUP BODY --}}
                            <tbody class="group-body group-{{ Str::slug($groupName) }}" style="display: none;">

                                @foreach($modules as $moduleKey => $module)

                                    <tr>
                                        {{-- MODULE LABEL --}}
                                        <td>{{ $module['label'] }}</td>

                                        {{-- MANAGE --}}
                                        <td>
                                            @if(in_array('manage', $module['actions']))
                                                <input type="checkbox" name="permissions[{{ $moduleKey }}]" value="yes">
                                            @endif
                                        </td>

                                        {{-- ADD --}}
                                        <td>
                                            @if(in_array('add', $module['actions']))
                                                <input type="checkbox" name="permissions[{{ $moduleKey }}_add]" value="yes">
                                            @endif
                                        </td>

                                        {{-- EDIT --}}
                                        <td>
                                            @if(in_array('edit', $module['actions']))
                                                <input type="checkbox" name="permissions[{{ $moduleKey }}_edit]" value="yes">
                                            @endif
                                        </td>

                                        {{-- STATUS --}}
                                        <td>
                                            @if(in_array('status', $module['actions']))
                                                <input type="checkbox" name="permissions[{{ $moduleKey }}_status]" value="yes">
                                            @endif
                                        </td>

                                        {{-- DELETE --}}
                                        <td>
                                            @if(in_array('delete', $module['actions']))
                                                <input type="checkbox" name="permissions[{{ $moduleKey }}_delete]" value="yes">
                                            @endif
                                        </td>

                                        {{-- EXTRA ACTIONS --}}
                                        <td>
                                            @php
                                                $extra = array_diff($module['actions'], ['manage','add','edit','status','delete']);
                                            @endphp

                                            @foreach($extra as $ex)
                                                <label class="badge bg-secondary">
                                                    <input type="checkbox" name="permissions[{{ $moduleKey }}_{{ $ex }}]" value="yes">
                                                    {{ ucfirst($ex) }}
                                                </label>
                                            @endforeach
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">Save Role Group</button>
        </div>

    </form>
</div>

{{-- EXPAND/COLLAPSE JS --}}
<script>
    document.querySelectorAll('.group-header').forEach(header => {
        header.addEventListener('click', function () {
            let group = this.dataset.group;
            let body = document.querySelector('.group-' + group);
            let icon = this.querySelector('.toggle-icon');

            if (body.style.display === "none") {
                body.style.display = "";
                icon.textContent = "➖";
            } else {
                body.style.display = "none";
                icon.textContent = "➕";
            }
        });
    });
</script>

@endsection
