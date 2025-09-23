@extends('layouts.teacher-app')

@section('title', 'Wallet Transactions')

@section('content')
    {{-- Wallet Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h6 class="card-title">Current Balance</h6>
                    <h4 class="mb-0">₹{{ number_format($balance, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h6 class="card-title">Total Credits</h6>
                    <h4 class="mb-0">₹{{ number_format($totalCredits, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h6 class="card-title">Total Debits</h6>
                    <h4 class="mb-0">₹{{ number_format($totalDebits, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions List --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Wallet Transactions</h5>
            <div class="mb-3 text-end">
                <button class="btn btn-warning" id="withdrawBtn">
                    <i class="fas fa-wallet"></i> Withdraw
                </button>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Source / Question Type</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                            <tr>
                                <td style="width:12%;">
                                    {{ $txn->created_at->format('d/m/Y') }}<br>
                                    {{ $txn->created_at->format('g:i A') }}
                                </td>
                                <td>
                                    <span class="badge {{ $txn->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($txn->type) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($txn->amount, 2) }}</td>
                                <td>{{ $txn->source }}</td>
                                <td>{{ $txn->details ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("withdrawBtn").addEventListener("click", function () {
            Swal.fire({
                title: 'Withdraw Amount',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    step: 0.01
                },
                inputPlaceholder: 'Enter amount',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                preConfirm: (amount) => {
                    if (!amount || amount <= 0) {
                        Swal.showValidationMessage("Please enter a valid amount");
                    }
                    return amount;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let amount = result.value;

                    fetch("{{ route('teacher.withdraw.request') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ amount: amount })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Success", data.message, "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error", data.message, "error");
                            }
                        })
                        .catch(err => {
                            Swal.fire("Error", "Something went wrong!", "error");
                        });
                }
            });
        });
    </script>
@endsection