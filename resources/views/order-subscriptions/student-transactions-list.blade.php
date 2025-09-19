@extends('layouts.app')

@section('title')
All Transactions
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">All Transactions</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage All Transactions here.</h6>

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
                 <th>Paid Amount</th>
                 <th>Payment Method</th>
                 <th>Payment Status</th>
                <th>Action Button</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $res)
            <tr>
                <td>{{ $res->created_at }}</td>
                <td>{{ $res->order->order_code ?? '-' }}</td>
                <td>{{ $res->student->name ?? '-' }}</td>
                <td>{{ $res->student->mobile ?? '-' }}</td>
                <td>{{ $res->billed_amount ?? '0' }}</td>
                <td>{{ $res->paid_amount ?? '0' }}</td>
                <td>{{ $res->payment_method ?? '-' }}</td>
                <td>{{ ucfirst($res->payment_status) }}</td>
                <!--<td>Active</td>-->
                <td>
                   <a href="{{route('students.student-order-detail',$res->order->id)}}"><i class="fa fa-eye"></i></a>
                    <a href="#"><i class="fa fa-user-graduate"></i></a>
                    <a href="{{route('user.generate-pdf', $res->order->id)}}"><i class="fa fa-download"></i></a>
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
