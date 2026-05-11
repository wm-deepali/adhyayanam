@extends('layouts.app')

@section('title')
    Test Series Orders
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Test Series Orders</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage Test Series Orders here.
                    </h6>
                </div>

                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>
            </div>

            {{-- SEARCH --}}
            <div class="mb-3">
                <form method="GET"
                      action="{{ route('order.test-series-orders') }}"
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

                    <a href="{{ route('order.test-series-orders') }}"
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
                            <th>Payment Status</th>
                            <th width="12%">Actions</th>
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
                                <td>{{ $res->student->name ?? '-' }}</td>
                                <td>{{ $res->student->mobile ?? '-' }}</td>
                                <td>₹ {{ $res->billed_amount ?? '0' }}</td>
                                <td>
                                   <span class="badge 
    {{ $res->payment_status == 'PAID' ? 'bg-success' : 'bg-warning' }}">
    {{ ucfirst($res->payment_status) }}
</span>
                                </td>
                               <td>
    <div class="dropdown">

        <button class="btn btn-sm btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

            Actions

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

            {{-- View Order --}}
            @if(\App\Helpers\Helper::canAccess('manage_students'))

                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2"
                       href="{{ route('students.student-order-detail', $res->id) }}">

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
                    <a class="dropdown-item d-flex align-items-center gap-2"
                       href="{{ route('students.student-profile-detail', $res->student->id) }}">

                        <i class="fa fa-user-graduate text-success"></i>

                        Student Profile

                    </a>
                </li>

            @endif


            {{-- Download Invoice --}}
            @if(\App\Helpers\Helper::canAccess('manage_students'))

                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2"
                       href="{{ route('students.generate-pdf', $res->id) }}">

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
                                <td colspan="8" class="text-center text-muted">
                                    No test series orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $orders->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>
@endsection