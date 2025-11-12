@extends('front-users.layouts.app')

@section('title')
My Wallet
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">My Wallet</h5>
                    <p class="mb-0 card-subtitle text-muted">
                        View your current wallet balance and all transaction history below.
                    </p>
                </div>

                <div class="card-body">
                    <!-- Wallet Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="bg-primary-light p-3 rounded text-center">
                                <h6 class="mb-1 text-primary">Available Balance</h6>
                                <h4 class="fw-bold mb-0">₹{{ number_format($wallet->balance ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-success-light p-3 rounded text-center">
                                <h6 class="mb-1 text-success">Total Credited</h6>
                                <h4 class="fw-bold mb-0">₹{{ number_format($wallet->total_credited ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-danger-light p-3 rounded text-center">
                                <h6 class="mb-1 text-danger">Total Debited</h6>
                                <h4 class="fw-bold mb-0">₹{{ number_format($wallet->total_debited ?? 0, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Table -->
                    <h6 class="mb-3">Recent Transactions</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Source</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $txn)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-{{ $txn->type == 'credit' ? 'success' : 'danger' }}">
                                            {{ ucfirst($txn->type) }}
                                        </span>
                                    </td>
                                    <td>₹{{ number_format($txn->amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $txn->source)) }}</td>
                                    <td>{{ $txn->details ?? '-' }}</td>
                                    <td>{{ $txn->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
