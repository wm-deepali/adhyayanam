@extends('layouts.app')

@section('title')
Courses Summary
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Courses Summary</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Courses Summary here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>Date &amp; Time</th>
                <th>Student Name</th>
                <th>Mobile Number</th>
                <th>Order Id</th>
                <th>Total Test </th>
                 <th>Completed</th>
                 <th>Pending</th>
                 <th> Status</th>
                <th>Action Button</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $res)
                        <tr>
                <td>{{$res->created_at}}</td>
                <td>{{$res->name}}</td>
                <td>{{$res->mobile}}</td>
                <td>{{$res->last_order}}</td>
                <td>{{$res->course_order_count}}</td>
                <td>{{$res->course_order_attempt_count}}</td>
                <td>{{$res->course_order_pending_count}}</td>
                <td>Active</td>
                <td>
                    <a href="#"><i class="fa fa-award"></i></a>
                    <a href="#"><i class="fa fa-user-graduate"></i></a>
                    <a href="#"><i class="fa fa-eye"></i></a>
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
