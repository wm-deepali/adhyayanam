@extends('layouts.app')

@section('title')
Students List
@endsection

@section('content')
<style>
  .toggle-handle
  {
    background-color: #fff;
    border-color: #fff;
  }
  .btn
  {
    color: #fff !important;
  }
</style>
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
                 <td>
                 <input data-id="{{$res->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $res->status == 'Active' ? 'checked' : '' }}>
                </td>
                <td>
                    <a href="{{route('students.student-profile-detail',$res->id )}}" title="View Student Detail"><i class="fa fa-eye"></i></a>
                    <a href="{{route('students.change-password', $res->id)}}" title="Change Password"><i class="fa fa-user-lock" ></i></a>
                    <a href="{{route('students.view-all-orders', $res->id)}}" title="View All Orders"><i class="fa fa-eye"></i></a>
                    <a href="#" title="View All Test"><i class="fa fa-award"></i></a>
                    <a href="#" title="View All Video's"><i class="fa fa-video"></i></a>
                </td>
            </tr>
            @endforeach
                    </tbody>
    </table>
                
            </div>
            <!-- Modal -->

        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'Active' : 'Inactive'; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{route("students.change-status")}}',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
@endpush