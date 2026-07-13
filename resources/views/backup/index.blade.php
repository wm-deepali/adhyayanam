@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Database Backup Management</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Settings Card --}}
    <div class="card mb-4">
        <div class="card-header">Backup Settings</div>
        <div class="card-body">
            <form action="{{ route('backup.settings.update') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Mode</label>
                        <select name="mode" id="mode" class="form-select" onchange="toggleAutoFields()">
                            <option value="manual" {{ $settings->mode === 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="auto" {{ $settings->mode === 'auto' ? 'selected' : '' }}>Auto</option>
                        </select>
                    </div>

                    <div class="col-md-3 auto-field" style="{{ $settings->mode === 'manual' ? 'display:none' : '' }}">
                        <label class="form-label">Frequency</label>
                        <select name="frequency" class="form-select">
                            <option value="daily" {{ $settings->frequency === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $settings->frequency === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $settings->frequency === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>

                    <div class="col-md-3 auto-field" style="{{ $settings->mode === 'manual' ? 'display:none' : '' }}">
                        <label class="form-label">Run Time</label>
                        <input type="time" name="run_time" class="form-control"
                               value="{{ $settings->run_time ? \Carbon\Carbon::parse($settings->run_time)->format('H:i') : '02:00' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Keep Last (backups on Drive)</label>
                        <input type="number" name="keep_last" class="form-control" min="1" max="100"
                               value="{{ $settings->keep_last }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </form>
        </div>
    </div>

    {{-- Manual Backup Now --}}
    <div class="card mb-4">
        <div class="card-header">Manual Backup</div>
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1">Last run: {{ $settings->last_run_at ? $settings->last_run_at->diffForHumans() : 'Never' }}</p>
            </div>
            <form action="{{ route('backup.run') }}" method="POST" onsubmit="return confirmBackup()">
                @csrf
                <button type="submit" class="btn btn-success">
                    Run Backup Now
                </button>
            </form>
        </div>
    </div>

    {{-- Backups List --}}
    <div class="card">
        <div class="card-header">Backups on Google Drive</div>
        <div class="card-body">
            @if (count($driveFiles) === 0)
                <p class="text-muted mb-0">No backups yet.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($driveFiles as $file)
                            <tr>
                                <td>{{ $file['name'] }}</td>
                                <td>{{ isset($file['size']) ? round($file['size'] / 1048576, 2) . ' MB' : '-' }}</td>
                                <td>{{ isset($file['createdTime']) ? \Carbon\Carbon::parse($file['createdTime'])->format('d M Y, h:i A') : '-' }}</td>
                                <td class="text-end">
                                    <form action="{{ route('backup.restore') }}" method="POST" class="d-inline"
                                          onsubmit="return confirmRestore()">
                                        @csrf
                                        <input type="hidden" name="file_id" value="{{ $file['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                                    </form>

                                    <form action="{{ route('backup.destroy') }}" method="POST" class="d-inline"
                                          onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="file_id" value="{{ $file['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script>
function toggleAutoFields() {
    const mode = document.getElementById('mode').value;
    document.querySelectorAll('.auto-field').forEach(el => {
        el.style.display = mode === 'auto' ? '' : 'none';
    });
}

function confirmBackup() {
    return confirm('Do you want to run the backup now? This may take a few moments.');
}

function confirmRestore() {
    return confirm('⚠️ Warning: This will overwrite the current database with this backup. Do you want to continue?');
}

function confirmDelete() {
    return confirm('This backup will be permanently deleted from Google Drive. Do you want to continue?');
}
</script>
@endsection