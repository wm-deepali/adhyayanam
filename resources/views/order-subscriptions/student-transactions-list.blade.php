@extends('layouts.app')

@section('title')
    All Transactions
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">All Transactions</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage all transactions here.
                    </h6>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            {{-- SEARCH --}}
            <div class="mb-3">
                <form method="GET"
                      action="{{ route('order.student-transactions-list') }}"
                      class="d-flex align-items-center gap-2">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="Search by order, student, mobile..."
                           style="width:260px;">

                    <button type="submit" class="btn btn-success btn-sm">
                        Search
                    </button>

                    <a href="{{ route('order.student-transactions-list') }}"
                       class="btn btn-outline-secondary btn-sm">
                        Clear
                    </a>
                </form>
            </div>

            {{-- Messages --}}
            <div class="mb-2">
                @include('layouts.includes.messages')
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date & Time</th>
                            <th>Order ID</th>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Billed Amount</th>
                            <th>Paid Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $res)
                            <tr>
                                <td>
                                    {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $res->created_at->format('d M Y, h:i A') }}</td>
                                <td>{{ $res->order->order_code ?? '-' }}</td>
                                <td>{{ $res->student->name ?? '-' }}</td>
                                <td>{{ $res->student->mobile ?? '-' }}</td>
                                <td>₹ {{ $res->billed_amount ?? '0' }}</td>
                                <td>₹ {{ $res->paid_amount ?? '0' }}</td>
                                <td>{{ ucfirst($res->payment_method ?? '-') }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($res->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- View Order --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_students') && optional($res->order)->id)
                                            <a href="{{ route('students.student-order-detail', $res->order->id) }}"
                                               title="View Order">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        {{-- View Student Profile (only if exists) --}}
                                        @if(
                                            \App\Helpers\Helper::canAccess('manage_students') &&
                                            optional($res->student)->id
                                        )
                                            <a href="{{ route('students.student-profile-detail', $res->student->id) }}"
                                               title="View Student Profile">
                                                <i class="fa fa-user-graduate"></i>
                                            </a>
                                        @endif

                                        {{-- Download Invoice --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_students') && optional($res->order)->id)
                                            <a href="{{ route('user.generate-pdf', $res->order->id) }}"
                                               title="Download Invoice">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</div>
@endsection