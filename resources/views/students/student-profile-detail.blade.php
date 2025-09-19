@extends('layouts.app')

@section('title')
Student Details
@endsection

@section('content')
<style>
    .card.shadow-sm {
	min-height: 274px;
}
.card-header.bg-transparent.border-0 {
	padding-top: 15px;
}
.card-body.pt-0 {
	padding-bottom: 0px;
}
.student-profile .card .card-header .profile_img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  margin: 10px auto;
  border: 10px solid #ccc;
  border-radius: 50%;
}

.student-profile .card h3 {
  font-size: 20px;
  font-weight: 700;
}

.student-profile .card p {
  font-size: 16px;
  color: #000;
}

.student-profile .table th,
.student-profile .table td {
  font-size: 14px;
  padding: 5px 10px;
  color: #000;
}
.card-header.bg-transparent.border-0 i {
	padding-right: 10px;
}
.btn-change-password {
	text-align: center;
	padding-top: 15px;
}
.btn-change-password a {
	text-decoration: none;
	background-color: #303c54;
	color: #fff;
	padding: 10px;
	border-radius: 2px;
}
.o-right {
	float: right;
	font-weight: 600;
}
.listn ul {
	list-style: none;
	padding: 10px;
}
</style>
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Profile Detail</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Students Profile here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4 student-profile">
               <div class="row">
                <div class="col-lg-4">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent text-center">
                      <img class="profile_img" src="{{asset('/'.$profile->avatar)}}" alt="">
                      <h3>{{ucfirst($profile->first_name)}} {{ucfirst($profile->last_name)}}</h3>
                    </div>
                  <div class="btn-change-password"><a href="{{route('students.change-password', $profile->id)}}">Change Password</a></div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Full Name</th>
                          <td width="2%">:</td>
                          <td>{{ucfirst($profile->first_name)}} {{ucfirst($profile->last_name)}}</td>
                        </tr>
                        <tr>
                          <th width="30%">Email Id</th>
                          <td width="2%">:</td>
                          <td>{{$profile->email}}</td>
                        </tr>
                        <tr>
                          <th width="30%">Mobile Number	</th>
                          <td width="2%">:</td>
                          <td>{{$profile->mobile}}</td>
                        </tr>
                        <tr>
                          <th width="30%">Gender</th>
                          <td width="2%">:</td>
                          <td>{{$profile->gender}}</td>
                        </tr>
                        <tr>
                          <th width="30%">DOB</th>
                          <td width="2%">:</td>
                          <td>{{$profile->date_of_birth}}</td>
                        </tr>
                        <tr>
                          <th width="30%">Full Address</th>
                          <td width="2%">:</td>
                          <td>{{$profile->full_address}}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                      </div>

                  </div>
              </div>
          </div>
<div class="bg-light rounded p-2">
    <div class="row">
    <div class="col-sm-6 col-lg-4">
        <div class="card mb-4 text-white bg-primary">
            <div class="card-body">
                <div class="fs-4 fw-semibold">Test Series</div>
                <div class="listn">
                    <ul>
                        <li>Total Orders <span class="o-right">{{$testSeries['totalOrder']}}</span></li>
                        <li>Total Billed Amount<span class="o-right">&#8377;{{$testSeries['totalBilledAmount']}}</span></li>
                        <li>Last Order ID<span class="o-right">#{{$testSeries['lastOrderCode']}}</span></li>
                        <li>Last Order Date & Time<span class="o-right">{{$testSeries['lastOrderDate']}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-lg-4">
        <div class="card mb-4 text-white bg-warning">
            <div class="card-body">
                <div class="fs-4 fw-semibold">Courses</div>
                <div class="listn">
                    <ul>
                        <li>Total Orders <span class="o-right">{{$course['totalOrder']}}</span></li>
                        <li>Total Billed Amount<span class="o-right">&#8377;{{$course['totalBilledAmount']}}</span></li>
                        <li>Last Order ID<span class="o-right">#{{$course['lastOrderCode']}}</span></li>
                        <li>Last Order Date & Time<span class="o-right">{{$course['lastOrderDate']}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-lg-4">
        <div class="card mb-4 text-white bg-danger">
            <div class="card-body">
                <div class="fs-4 fw-semibold">Study Material</div>
                <div class="listn">
                    <ul>
                        <li>Total Orders <span class="o-right">{{$studyMaterial['totalOrder']}}</span></li>
                        <li>Total Billed Amount<span class="o-right">&#8377;{{$studyMaterial['totalBilledAmount']}}</span></li>
                        <li>Last Order ID<span class="o-right">#{{$studyMaterial['lastOrderCode']}}</span></li>
                        <li>Last Order Date & Time<span class="o-right">{{$studyMaterial['lastOrderDate']}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
</div>
@endsection