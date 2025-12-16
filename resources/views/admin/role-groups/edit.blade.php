@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Role Group</h5>
    </div>

    <form action="{{ route('role-groups.update', $group->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="card-body">

            <div class="mb-3">
                <label>Role Group Name</label>
                <input type="text" name="name" value="{{ $group->name }}" class="form-control" required>
            </div>

            <!-- <div class="mb-3">
                <label>Role Type</label>
                <select name="type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Academic" {{ $group->type == 'Academic' ? 'selected' : '' }}>Academic</option>
                    <option value="Universities" {{ $group->type == 'Universities' ? 'selected' : '' }}>Universities</option>
                    <option value="Competitive" {{ $group->type == 'Competitive' ? 'selected' : '' }}>Competitive</option>
                </select>
            </div> -->

            <h5 class="mt-4 mb-3">Permissions</h5>

            @php
                $groups = config('admin_permissions');
                $saved = $group->permissions ?? [];
            @endphp

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

                        @foreach($groups as $groupName => $modules)

                            <!-- GROUP HEADER -->
                            <tr class="group-header bg-light fw-bold" data-group="{{ Str::slug($groupName) }}" style="cursor:pointer;">
                                <td colspan="7">
                                    <span class="toggle-icon me-2">➕</span> {{ $groupName }}
                                </td>
                            </tr>

                            <!-- GROUP MODULES -->
                            <tbody class="group-body group-{{ Str::slug($groupName) }}" style="display:none;">

                                @foreach($modules as $moduleKey => $module)

                                    @php
                                        $actions = $module['actions'];
                                        $extraActions = array_diff($actions, ['manage','add','edit','status','delete']);
                                    @endphp

                                    <tr>
                                        <!-- MODULE NAME -->
                                        <td>{{ $module['label'] }}</td>

                                        <!-- MANAGE -->
                                        <td>
                                            @if(in_array('manage', $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $moduleKey }}]"
                                                    value="yes"
                                                    {{ ($saved[$moduleKey] ?? 'no') == 'yes' ? 'checked' : '' }}>
                                            @endif
                                        </td>

                                        <!-- ADD -->
                                        <td>
                                            @if(in_array('add', $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $moduleKey }}_add]"
                                                    value="yes"
                                                    {{ ($saved[$moduleKey . '_add'] ?? 'no') == 'yes' ? 'checked' : '' }}>
                                            @endif
                                        </td>

                                        <!-- EDIT -->
                                        <td>
                                            @if(in_array('edit', $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $moduleKey }}_edit]"
                                                    value="yes"
                                                    {{ ($saved[$moduleKey . '_edit'] ?? 'no') == 'yes' ? 'checked' : '' }}>
                                            @endif
                                        </td>

                                        <!-- STATUS -->
                                        <td>
                                            @if(in_array('status', $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $moduleKey }}_status]"
                                                    value="yes"
                                                    {{ ($saved[$moduleKey . '_status'] ?? 'no') == 'yes' ? 'checked' : '' }}>
                                            @endif
                                        </td>

                                        <!-- DELETE -->
                                        <td>
                                            @if(in_array('delete', $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $moduleKey }}_delete]"
                                                    value="yes"
                                                    {{ ($saved[$moduleKey . '_delete'] ?? 'no') == 'yes' ? 'checked' : '' }}>
                                            @endif
                                        </td>

                                        <!-- EXTRA ACTIONS -->
                                        <td>
                                            @foreach($extraActions as $ex)
                                                <label class="badge bg-secondary">
                                                    <input type="checkbox"
                                                        name="permissions[{{ $moduleKey }}_{{ $ex }}]"
                                                        value="yes"
                                                        {{ ($saved[$moduleKey . '_' . $ex] ?? 'no') == 'yes' ? 'checked' : '' }}>
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
            <button class="btn btn-primary">Update Role Group</button>
        </div>

    </form>
</div>

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
