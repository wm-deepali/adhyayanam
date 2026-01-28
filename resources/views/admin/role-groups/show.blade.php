@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Role Group Details</h5>

            <a href="{{ route('role-groups.index') }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>{{ $roleGroup->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $roleGroup->status)) }}</td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $roleGroup->creator->name ?? 'Super Admin' }}</td>
                </tr>
                <tr>
                    <th>Approved By</th>
                    <td>{{ $roleGroup->approver->name ?? '-' }}</td>
                </tr>
            </table>

            <h6 class="mt-3">Permissions</h6>
            @php
                use Illuminate\Support\Str;

                $groups = config('admin_permissions');
                $saved = $roleGroup->permissions ?? [];
            @endphp

            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle">

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

                                {{-- GROUP HEADER --}}
                                <tr class="group-header bg-light fw-bold" data-group="{{ Str::slug($groupName) }}"
                                    style="cursor:pointer;">
                                    <td colspan="7">
                                        <span class="toggle-icon me-2">➕</span> {{ $groupName }}
                                    </td>
                                </tr>

                                {{-- GROUP BODY --}}
                            <tbody class="group-body group-{{ Str::slug($groupName) }}" style="display:none;">

                                @foreach($modules as $moduleKey => $module)

                                    @php
                                        $actions = $module['actions'];
                                        $extraActions = array_diff($actions, ['manage', 'add', 'edit', 'status', 'delete']);
                                    @endphp

                                    <tr>
                                        <td>{{ $module['label'] }}</td>

                                        {{-- MANAGE --}}
                                        <td class="text-center">
                                            @if(in_array('manage', $actions) && ($saved[$moduleKey] ?? null) === 'yes')
                                                <span class="badge bg-success">✔</span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        {{-- ADD --}}
                                        <td class="text-center">
                                            @if(in_array('add', $actions) && ($saved[$moduleKey . '_add'] ?? null) === 'yes')
                                                <span class="badge bg-success">✔</span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        {{-- EDIT --}}
                                        <td class="text-center">
                                            @if(in_array('edit', $actions) && ($saved[$moduleKey . '_edit'] ?? null) === 'yes')
                                                <span class="badge bg-success">✔</span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="text-center">
                                            @if(in_array('status', $actions) && ($saved[$moduleKey . '_status'] ?? null) === 'yes')
                                                <span class="badge bg-success">✔</span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        {{-- DELETE --}}
                                        <td class="text-center">
                                            @if(in_array('delete', $actions) && ($saved[$moduleKey . '_delete'] ?? null) === 'yes')
                                                <span class="badge bg-success">✔</span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        {{-- EXTRA --}}
                                        <td>
                                            @foreach($extraActions as $ex)
                                                @if(($saved[$moduleKey . '_' . $ex] ?? null) === 'yes')
                                                    <span class="badge bg-success me-1">
                                                        {{ ucfirst($ex) }}
                                                    </span>
                                                @endif
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