@extends('layouts.app')

@section('title', 'Teacher Wallet')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Teacher Wallet Overview</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Teacher Detail</th>
                        <th>Current Balance</th>
                        <th>Total Credits</th>
                        <th>Total Debits</th>
                        <th>Withdrawal Request</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->created_at->format('d/m/Y g:i A') }}</td>
                        <td>
                            <strong>{{ $teacher->full_name }}</strong><br>
                            {{ $teacher->email }}<br>
                            {{ $teacher->mobile_number }}
                        </td>
                        <td>₹{{ number_format($teacher->wallet_balance, 2) }}</td>
                        <td>₹{{ number_format($teacher->transactions()->where('type', 'credit')->sum('amount'), 2) }}</td>
                        <td>₹{{ number_format($teacher->transactions()->where('type', 'debit')->sum('amount'), 2) }}</td>
                        <td>
                            {{ $teacher->withdrawalRequests()->count() }}
                        </td>
                        <td>
                            <span class="badge {{ $teacher->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $teacher->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('teacher.transactions.index', ['teacher_id' => $teacher->id]) }}" class="btn btn-primary btn-sm">
                                View History
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No teachers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection
