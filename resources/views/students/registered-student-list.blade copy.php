@extends('layouts.app')

@section('title')
Students List
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Manage Students</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Students List here.</h6>

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
                <th>Email Id</th>
                 <th>Total Orders</th>
                 <th>Total Paid</th>
                 <th> Status</th>
                <th>Action Button</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $res)
                        <tr>
                <td>{{$res->created_at}}</td>
                <td>{{$res->last_order}}</td>
                <td>{{$res->name}}</td>
                <td>{{$res->mobile}}</td>
                <td>{{$res->email}}</td>
                 <td>{{$res->orders_count}}</td>
                 <td>RS.{{$res->transactions_sum_paid_amount ?? 0}}</td>
                <td>Active</td>
                <td>
                    <a href="{{route('students.student-profile-detail',$res->id )}}"><i class="fa fa-eye"></i></a>
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-user-lock" ></i></a>
                    <a href="#"><i class="fa fa-user-slash"></i></a>
                    <a href="#"><i class="fa fa-eye"></i></a>
                    <a href="#"><i class="fa fa-award"></i></a>
                    <a href="#"><i class="fa fa-video"></i></a>
                </td>
            </tr>
            @endforeach
                    </tbody>
    </table>
                
            </div>
            <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="mb-3">
         <label for="name" class="form-label">New Password</label>
         <input type="text" class="form-control" name="name" placeholder="New Password" required="">
        </div>
        <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
  <label class="form-check-label" for="flexCheckChecked">
    Send New password notification to user email
  </label>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Change Password</button>
      </div>
    </div>
  </div>
</div>


        </div>
    </div>
</div>
@endsection
