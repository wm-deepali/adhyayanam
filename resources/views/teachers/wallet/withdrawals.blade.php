@extends('layouts.teacher-app')

@section('title', 'Withdrawal Requests')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Withdrawal Requests</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                            <th>Reference ID</th>
                            <th>Remarks</th>
                            <th>Screenshot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawalRequests as $req)
                            <tr>
                                <td>{{ $req->created_at->format('d/m/Y g:i A') }}</td>
                                <td>₹{{ number_format($req->amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge 
                                            {{ $req->status == 'pending' ? 'bg-warning' : ($req->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td>{{ $req->payment_date?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $req->reference_id ?? '-' }}</td>
                                <td>{{ $req->remarks ?? '-' }}</td>
                                <td>
                                    @if($req->screenshot)
                                        <a href="{{ asset('storage/' . $req->screenshot) }}" target="_blank"><img src="{{ asset('storage/' . $req->screenshot) }}" width="50" height="25"></a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No withdrawal requests found</td>
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
@endsection