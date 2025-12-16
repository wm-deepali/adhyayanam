@extends('layouts.app')

@section('title')
    All Orders
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Orders</h5>
                <h6 class="card-subtitle mb-2 text-muted">Manage All Orders here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Search Box -->
                        <form method="GET" action="{{ route('order.student-all-orders') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-success">Search</button>
                        </form>
                    </div>

                    <table class="table table-striped mt-5 table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Date &amp; Time</th>
                                <th>Order Id</th>
                                <th>Order Type</th>
                                <th>Student Name</th>
                                <th>Mobile Number</th>
                                <th>Paid Amount</th>
                                <th>Payment Status</th>
                                <th>Transaction ID</th>
                                <th>Order Status</th>
                                <th>Status</th>
                                <th>Action Button</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $res)
                                <tr>
                                    <td>{{ $res->created_at }}</td>
                                    <td>{{ $res->order_code ?? '-' }}</td>
                                    <td>{{ $res->order_type ?? '-' }}</td>
                                    <td>{{ $res->student->name ?? '-' }}</td>
                                    <td>{{ $res->student->mobile ?? '-' }}</td>
                                    <td>{{ $res->total ?? '0' }}</td>
                                    <td>{{ ucfirst($res->payment_status) }}</td>
                                    <td>{{ $res->transaction_id ?? '-' }}</td>
                                    <td>{{ ucfirst($res->order_status) }}</td>
                                    <td>Active</td>
                                    <td>
                                        @if(\App\Helpers\Helper::canAccess('manage_students'))
                                            <a href="{{ route('students.student-order-detail', $res->id) }}" title="View Order">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        @if(\App\Helpers\Helper::canAccess('manage_students'))
                                            <a href="{{ route('students.student-profile-detail', $res->student->id) }}"
                                                title="View Student Profile">
                                                <i class="fa fa-user-graduate"></i>
                                            </a>
                                        @endif

                                        @if(\App\Helpers\Helper::canAccess('manage_students'))
                                            <a href="{{ route('user.generate-pdf', $res->id) }}" title="Download Invoice">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection