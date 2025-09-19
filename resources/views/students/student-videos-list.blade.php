@extends('layouts.app')

@section('title')
Current Affair
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">All Video's</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage All Video's here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <table class="table table-striped mt-5 table-responsive table-bordered">
        <thead>
            <tr>
                <th>Date &amp; Time</th>
                <th>Student Name</th>
                <th>Mobile Number</th>
                <th>Order Id</th>
                <th>Course Name </th>
                 <th>Video Tittle</th>
                 <th>Duration</th>
                 <th>Status</th>
                <th>Action Button</th>
            </tr>
        </thead>
        <tbody>
                        <tr>
                <td>2024-05-17 13:52:12</td>
                <td>Osaid</td>
                <td>99999999</td>
                 <td>oid8993</td>
                 <td>UPSC</td>
                 <td>Tittle</td>
                 <td>78</td>
                <td>Active</td>
                <td>
                    <a href="#"><i class="fa fa-user-graduate"></i></a>
                    <a href="#"><i class="fa fa-bar-chart"></i></a>
                    <a href="#"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
                    </tbody>
    </table>
            </div>

        </div>
    </div>
</div>
@endsection
