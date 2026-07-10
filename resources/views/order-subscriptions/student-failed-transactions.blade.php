@extends('layouts.app')

@section('title')
    Failed & Cancelled Payments
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">Failed & Cancelled Payments</h5>
                        <h6 class="card-subtitle text-muted">
                            Orders where the student did not complete payment -- either the bank/gateway
                            declined it (Failed) or the student cancelled/dropped out mid-checkout (Cancelled).
                        </h6>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                {{-- SEARCH --}}
                <div class="mb-3">
                    <form method="GET" action="{{ route('order.student-failed-transactions') }}"
                        class="d-flex align-items-center gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="Search by order, student, mobile, mode..."
                            style="width:280px;">

                        <button type="submit" class="btn btn-danger btn-sm">
                            Search
                        </button>

                        <a href="{{ route('order.student-failed-transactions') }}" class="btn btn-outline-secondary btn-sm">
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
                                <th>Payment Mode</th>
                                <th>Gateway</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th width="12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $res)
                                @php
                                    // This list only ever contains 'Failed' or 'Cancelled' (see
                                    // OrderController::allFailedTransactions), but we still read the
                                    // actual value rather than hardcoding the badge/label.
                                    $badgeClass = $res->payment_status == 'CANCELLED' ? 'bg-secondary' : 'bg-danger';
                                @endphp
                                <tr>
                                    <td>
                                        {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $res->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $res->order_code ?? '-' }}</td>
                                    <td>{{ $res->student->name ?? '-' }}</td>
                                    <td>{{ $res->student->mobile ?? '-' }}</td>
                                    <td>₹ {{ $res->billed_amount ?? '0' }}</td>

                                    {{-- PAYMENT MODE (UPI / Credit Card / Net Banking etc) --}}
                                    <td>{{ $res->payment_mode ?? '-' }}</td>

                                    {{-- GATEWAY (CashFree) --}}
                                    <td>{{ $res->payment_gateway ?? 'CashFree' }}</td>

                                    <td>
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $res->payment_status ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- REMARK (e.g. "Cancelled by user on payment page") --}}
                                    <td>
                                        @if($res->payment_remark)
                                            <span title="{{ $res->payment_remark }}">
                                                {{ Illuminate\Support\Str::limit($res->payment_remark, 30) }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>

                                        <div class="dropdown">

                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                Actions

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                {{-- View Order --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_students'))

                                                    <li>
                                                        <a href="{{ route('students.student-order-detail', $res->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">

                                                            <i class="fa fa-eye text-primary"></i>

                                                            View Order

                                                        </a>
                                                    </li>

                                                @endif


                                                {{-- View Student Profile --}}
                                                @if(
                                                        \App\Helpers\Helper::canAccess('manage_students') &&
                                                        optional($res->student)->id
                                                    )

                                                    <li>
                                                        <a href="{{ route('students.student-profile-detail', $res->student->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">

                                                            <i class="fa fa-user-graduate text-success"></i>

                                                            Student Profile

                                                        </a>
                                                    </li>

                                                @endif


                                                {{-- Download Invoice --}}
                                                {{-- NOTE: Failed/Cancelled orders never completed payment, so no
                                                     invoice really exists for them. Kept here only if your
                                                     generate-pdf route already guards against non-paid orders;
                                                     otherwise consider removing this action for this screen. --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_students'))

                                                    <li>
                                                        <a href="{{ route('students.generate-pdf', $res->id) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">

                                                            <i class="fa fa-download text-danger"></i>

                                                            Download Invoice

                                                        </a>
                                                    </li>

                                                @endif

                                            </ul>

                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        No failed or cancelled payments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection