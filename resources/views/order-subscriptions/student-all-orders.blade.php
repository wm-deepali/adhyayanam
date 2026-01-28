@extends('layouts.app')

@section('title')
    All Orders
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">All Orders</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage all orders here.
                        </h6>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            ← Back
                        </a>
                    </div>
                </div>

                {{-- SEARCH --}}
                <div class="mb-3">
                    <form method="GET" action="{{ route('order.student-all-orders') }}"
                        class="d-flex align-items-center gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="Search by order, student, mobile..."
                            style="width:260px;">

                        <button type="submit" class="btn btn-success btn-sm">
                            Search
                        </button>

                        <a href="{{ route('order.student-all-orders') }}" class="btn btn-outline-secondary btn-sm">
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
                                <th>Order Type</th>
                                <th>Student Name</th>
                                <th>Mobile</th>
                                <th>Paid Amount</th>
                                <th>Payment Status</th>
                                <th>Transaction ID</th>
                                <th>Order Status</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $res)
                                <tr>
                                    <td>
                                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $res->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $res->order_code ?? '-' }}</td>
                                    <td>{{ $res->order_type ?? '-' }}</td>
                                    <td>{{ $res->student->name ?? '-' }}</td>
                                    <td>{{ $res->student->mobile ?? '-' }}</td>
                                    <td>₹ {{ $res->total ?? '0' }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($res->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $res->transaction_id ?? '-' }}</td>
                                    <td>{{ ucfirst($res->order_status) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- View Order --}}
                                            @if(\App\Helpers\Helper::canAccess('manage_students'))
                                                <a href="{{ route('students.student-order-detail', $res->id) }}" title="View Order">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif

                                            {{-- View Student Profile --}}
                                            @if(
                                                    \App\Helpers\Helper::canAccess('manage_students') &&
                                                    !empty($res->student) &&
                                                    !empty($res->student->id)
                                                )
                                                <a href="{{ route('students.student-profile-detail', $res->student->id) }}"
                                                    title="View Student Profile">
                                                    <i class="fa fa-user-graduate"></i>
                                                </a>
                                            @endif

                                            {{-- Download Invoice --}}
                                            @if(\App\Helpers\Helper::canAccess('manage_students'))
                                                <a href="{{ route('user.generate-pdf', $res->id) }}" title="Download Invoice">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection