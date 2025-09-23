@extends('layouts.app')

@section('title', 'Withdrawal Requests')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Withdrawal Requests</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Teacher</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>Reference ID</th>
                        <th>Remarks</th>
                        <th>Screenshot</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawalRequests as $req)
                        <tr id="row-{{ $req->id }}">
                            <td>{{ $req->created_at->format('d/m/Y g:i A') }}</td>
                            <td>
                                <strong>{{ $req->teacher->full_name ?? '-' }}</strong><br>
                                {{ $req->teacher->email ?? '-' }}
                            </td>
                            <td>₹{{ number_format($req->amount, 2) }}</td>
                            <td id="status-{{ $req->id }}">
                                <span class="badge 
                                    {{ $req->status == 'pending' ? 'bg-warning' : ($req->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td id="payment_date-{{ $req->id }}">{{ $req->payment_date?->format('d/m/Y') ?? '-' }}</td>
                            <td id="reference_id-{{ $req->id }}">{{ $req->reference_id ?? '-' }}</td>
                            <td id="remarks-{{ $req->id }}">{{ $req->remarks ?? '-' }}</td>
                            <td id="screenshot-{{ $req->id }}">
                                @if($req->screenshot)
                                    <a href="{{ asset('storage/' . $req->screenshot) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $req->screenshot) }}" width="50" height="25">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($req->status == 'pending')
                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $req->id }}">Approve</button>
                                    <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $req->id }}">Reject</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No withdrawal requests found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $withdrawalRequests->links() }}
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="approveForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="status" value="approved">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Withdrawal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Reference ID</label>
                        <input type="text" name="reference_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Screenshot</label>
                        <input type="file" name="screenshot" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirm Payment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
    const approveForm = document.getElementById('approveForm');
    let currentId = null;

    // Approve button click
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            currentId = this.dataset.id;
            approveForm.reset();
            approveModal.show();
        });
    });

    // Reject button click
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            if (!confirm('Are you sure you want to reject this request?')) return;

            fetch(`/teacher-withdrawal/${id}/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({status: 'rejected'})
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`status-${id}`).innerHTML = '<span class="badge bg-danger">Rejected</span>';
                    document.getElementById(`row-${id}`).querySelector('td:last-child').innerHTML = '-';
                }
            });
        });
    });

    // Approve form submit via AJAX
    approveForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!currentId) return;

        const formData = new FormData(approveForm);

        fetch(`/teacher-withdrawal/${currentId}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update row
                document.getElementById(`status-${currentId}`).innerHTML = '<span class="badge bg-success">Approved</span>';
                document.getElementById(`payment_date-${currentId}`).innerText = data.withdrawal.payment_date;
                document.getElementById(`reference_id-${currentId}`).innerText = data.withdrawal.reference_id;
                document.getElementById(`remarks-${currentId}`).innerText = data.withdrawal.remarks ?? '-';
                if (data.withdrawal.screenshot_url) {
                    document.getElementById(`screenshot-${currentId}`).innerHTML = `<a href="${data.withdrawal.screenshot_url}" target="_blank"><img src="${data.withdrawal.screenshot_url}" width="50" height="25"></a>`;
                } else {
                    document.getElementById(`screenshot-${currentId}`).innerText = '-';
                }

                // Remove action buttons
                document.getElementById(`row-${currentId}`).querySelector('td:last-child').innerHTML = '-';
                approveModal.hide();
            }
        });
    });
});
</script>

@endsection
