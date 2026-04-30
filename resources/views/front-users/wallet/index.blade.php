@extends('front-users.layouts.app')

@section('title')
    My Wallet
@endsection

@section('content')

    <style>
        /* ====================== DESKTOP (No Change) ====================== */
        .bg-primary-light   { background: #e0f2fe; }
        .bg-success-light   { background: #ecfdf5; }
        .bg-danger-light    { background: #fee2e2; }

        /* ====================== MOBILE CARD VIEW ====================== */
        .wallet-balance-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .balance-box {
            text-align: center;
            padding: 20px 15px;
            border-radius: 16px;
            margin-bottom: 15px;
        }

        .balance-amount {
            font-size: 28px;
            font-weight: 700;
            margin: 8px 0;
        }

        .txn-mobile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            padding: 18px 20px;
            margin-bottom: 16px;
        }

        .txn-type {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }

        .amount-credit  { color: #22c55e; font-weight: 700; }
        .amount-debit   { color: #ef4444; font-weight: 700; }
        
         @media (max-width: 740px) {
    
    .content {
    
    padding: 0 !important;
    
}

}
    </style>

    <section class="content py-4">
        <div class="container">

            <!-- Wallet Summary - Desktop + Mobile -->
            <div class="row mb-4 g-3">
                <div class="col-md-4 col-12">
                    <div class="balance-box bg-primary-light">
                        <h6 class="mb-1 text-primary">Available Balance</h6>
                        <div class="balance-amount text-primary">
                            ₹{{ number_format($wallet->balance ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="balance-box bg-success-light">
                        <h6 class="mb-1 text-success">Total Credited</h6>
                        <div class="balance-amount text-success">
                            ₹{{ number_format($wallet->total_credited ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="balance-box bg-danger-light">
                        <h6 class="mb-1 text-danger">Total Debited</h6>
                        <div class="balance-amount text-danger">
                            ₹{{ number_format($wallet->total_debited ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 fw-bold">Recent Transactions</h5>

            <!-- ==================== DESKTOP TABLE VIEW ==================== -->
            <div class="d-none d-lg-block">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
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
                                        <td class="{{ $txn->type == 'credit' ? 'amount-credit' : 'amount-debit' }}">
                                            ₹{{ number_format($txn->amount, 2) }}
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $txn->source)) }}</td>
                                        <td>{{ $txn->details ?? '-' }}</td>
                                        <td>{{ $txn->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            No transactions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==================== MOBILE CARD VIEW ==================== -->
            <div class="d-lg-none">
                @forelse($transactions as $txn)
                    <div class="txn-mobile-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="txn-type bg-{{ $txn->type == 'credit' ? 'success' : 'danger' }} text-white">
                                    {{ ucfirst($txn->type) }}
                                </span>
                            </div>
                            <div class="text-end">
                                <div class="{{ $txn->type == 'credit' ? 'amount-credit' : 'amount-debit' }} fs-5">
                                    ₹{{ number_format($txn->amount, 2) }}
                                </div>
                                <small class="text-muted">{{ $txn->created_at->format('d M Y') }}</small>
                            </div>
                        </div>

                        <div class="mb-2">
                            <strong>Source:</strong> 
                            {{ ucfirst(str_replace('_', ' ', $txn->source)) }}
                        </div>

                        @if($txn->details)
                            <div class="text-muted small">
                                {{ $txn->details }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="alert alert-info text-center py-5">
                        No transactions found.
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </section>

@endsection