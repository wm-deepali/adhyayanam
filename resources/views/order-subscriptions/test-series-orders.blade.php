@extends('layouts.app')

@section('title')
Test Series Orders
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Test Series Orders</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Test Series Orders here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
               
               <table class="table table-striped mt-5 table-responsive table-bordered">
        <thead>
            <tr>
                <th>Date &amp; Time</th>
                <th>Order Id</th>
                <th>Student Name</th>
                <th>Mobile Number</th>
                 <th>Billed Amount</th>
                 <th>Transaction ID</th>
                 <th>Order Status</th>
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
                <td>{{ $res->billed_amount ?? '0' }}</td>
                <td>{{ ucfirst($res->payment_status) }}</td>
                <!--<td>{{ $res->transaction ?? '-' }}</td>-->
                <!--<td>{{ ucfirst($res->order_status) }}</td>-->
                <!--<td>Active</td>-->
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
