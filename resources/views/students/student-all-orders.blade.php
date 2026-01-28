@extends('layouts.app')

@section('title')
    All Orders
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="display: inline-block;">All Orders</h5>
                <h6 class="card-subtitle mb-2 text-muted" style="display: inline-block;">Manage All Orders here.</h6>
                <div class="justify-content-end" style="display: grid;float:right;">
                    <a href='{{route('students.registered-student-list')}}' class="btn btn-primary">Back</a>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <h6>Student Name: {{$orders[0]->student->name ?? ''}}</h6>
                    <h6>Student Mobile: {{$orders[0]->student->mobile ?? ''}}</h6>
                    <table class="table table-striped mt-5 table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Date &amp; Time</th>
                                <th>Order Id</th>
                                <th>Order Type</th>
                                <th>Billed Amount</th>
                                <th>Payment Status</th>
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
                                    <td>{{ $res->billed_amount ?? '0' }}</td>
                                    <td>{{ ucfirst($res->payment_status) }}</td>
                                    <td>{{ $res->transaction_id ?? '-' }}</td>
                                    <td>{{ ucfirst($res->order_status) }}</td>
                                    <td>
                                        @if($res->order_type === 'Course' && !empty($res->student_id) && !empty($res->package_id))
                                            <a href="{{ route('students.student-course-detail', [$res->student_id, $res->package_id]) }}"
                                                title="View Course">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                        @elseif($res->order_type === 'Test Series' && !empty($res->student_id) && !empty($res->package_id))
                                            <a href="{{ route('test-series.detail', [$res->student_id, $res->package_id]) }}"
                                                title="View Test Series">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                        @elseif($res->order_type === 'Study Material')
                                                                    <a href="{{ route('students.student-study-material-detail', [
                                                'studentId' => $res->student_id,
                                                'materialId' => $res->package_id
                                            ]) }}" title="View Study Material">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>

                                        @else
                                            {{-- Fallback: Order detail --}}
                                            <a href="{{ route('students.student-order-detail', $res->id) }}" title="View Order">
                                                <i class="fa fa-eye"></i>
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