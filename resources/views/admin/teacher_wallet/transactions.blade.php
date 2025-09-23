@extends('layouts.app')

@section('title', 'Teacher Transactions')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                Transactions
                @if(isset($teacher))
                    of {{ $teacher->full_name }}
                @endif
            </h5>
        </div>
        <div class="card-body">

            {{-- Optional Summary --}}
            @if($teacher)
                <div class="mb-3 d-flex flex-wrap gap-3">
                    <div class="p-2 bg-light border rounded">
                        <strong>Current Balance:</strong>
                        <span class="text-success">₹{{ number_format($balance, 2) }}</span>
                    </div>
                    <div class="p-2 bg-light border rounded">
                        <strong>Total Credits:</strong>
                        <span class="text-primary">₹{{ number_format($totalCredits, 2) }}</span>
                    </div>
                    <div class="p-2 bg-light border rounded">
                        <strong>Total Debits:</strong>
                        <span class="text-danger">₹{{ number_format($totalDebits, 2) }}</span>
                    </div>
                </div>
            @endif


            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit"
                        type="button" role="tab">Credit</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="debit-tab" data-bs-toggle="tab" data-bs-target="#debit" type="button"
                        role="tab">Debit</button>
                </li>
            </ul>

            <div class="tab-content" id="transactionTabsContent">

                {{-- Credit Tab --}}
                <div class="tab-pane fade show active" id="credit" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Teacher</th>
                                    <th>Amount</th>
                                    <th>Source / Question Type</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions->where('type', 'credit') as $txn)
                                    <tr>
                                        <td>{{ $txn->created_at->format('d/m/Y g:i A') }}</td>
                                        <td>
                                            {{ $txn->teacher->full_name ?? '-' }}<br>
                                            {{ $txn->teacher->email ?? '-' }}
                                        </td>
                                        <td>₹{{ number_format($txn->amount, 2) }}</td>
                                        <td>{{ $txn->source }}</td>
                                        <td>{{ $txn->details ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No credit transactions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Debit Tab --}}
                <div class="tab-pane fade" id="debit" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Teacher</th>
                                    <th>Amount</th>
                                    <th>Source / Question Type</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions->where('type', 'debit') as $txn)
                                    <tr>
                                        <td>{{ $txn->created_at->format('d/m/Y g:i A') }}</td>
                                        <td>
                                            {{ $txn->teacher->full_name ?? '-' }}<br>
                                            {{ $txn->teacher->email ?? '-' }}
                                        </td>
                                        <td>₹{{ number_format($txn->amount, 2) }}</td>
                                        <td>{{ $txn->source }}</td>
                                        <td>{{ $txn->details ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No debit transactions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection