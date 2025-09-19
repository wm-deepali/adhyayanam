@extends('front-users.layouts.app')

@section('title')
Order Details
@endsection

@section('content')
<style>
    .company-name {
	font-size: 18px;
	font-weight: 600;
}
.student-details-details {
	text-align: right;
}
.f10 {
	font-size: 12px;
}
.sub-total ul {
	list-style: none;
	padding: 0;
}
.sub-total {
	float: right;
}
.sub-total ul {
	width: 250px;
}
.sub-total ul li .fr {
	float: right;
}
.sub-total ul li:last-child {
	font-size: 16px;
	font-weight: 600;
}
.sub-total ul li:last-child {
	font-size: 16px;
	font-weight: 600;
	background-color: #eee;
	padding: 10px 5px;
}
.sub-total ul li {
	padding: 1px 5px;
}
.feather-printer,.feather-download
{
    width:15px !important;
}
</style>
<section class="content">
	<div class="row">
		<div class="col-12 col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">Order Details</h5>
					<p class="mb-0 card-subtitle text-muted"></p>
				</div>
				<div class="card-body">
					<div class="container mt-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="company-details">
                                    <div class="company-logo">
                                        <img src="{{asset('images/Neti-logo.svg#full')}}"/>
                                    </div>
                                    <div class="company-name">NETI IAS</div>
                                    <div class="company-address">Viaspir, Post Basahiya, Atrouliya, Azamgarh,Uttar Pradesh, India
Pin Code - 223223 </div>
                                    <div class="company contact">
                                      Contact Number:+91-9120930909<br>
                                      Email Id: adhyayaniasacademy@gmail.com<br>
                                    </div>
                                </div>
                            </div>
                        <div class="col-sm-6">
                            <div class="student-details-details">
                                <div class="company-name">{{$order->student->name ?? ''}}</div>
                                <div class="company-address">{{$order->student->full_address ?? ''}}</div>
                                    <div class="company contact">
                                      Phone: {{$order->student->mobile ?? ''}}<br>
                                      Email: {{$order->student->email ?? ''}}<br>
                                      Order Date & Time: {{date('d-m-Y g:i A', strtotime($order->created_at))}}<br>
                                      Order Id: {{$order->order_code}}<br>
                                      Order Type: {{$order->order_type}}<br>
                                      Payment Status: {{$order->payment_status}}<br>
                                      Transaction Id: {{$order->transaction_id ?? ''}}<br>
                                    </div>
                                </div>
                            </div>
                        </div>
              
                        <div class="order-tab">
                            <table class="table table-striped mt-5">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Order Type</th>
                                        <th>Detail</th>
                                        <th>Quantity</th>
                                        <th>Rates</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{$order->order_type}}</td>
                                         <td>
                                         {{$order->detail ?? ''}}
                                         </td>
                                         <td>{{$order->quantity ?? 0}}</td>
                                         <td>&#8377;{{$order->billed_amount ?? 0}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="sub-total">
                                <ul>
                                    <li> Sub Total:<span class="fr">&#8377;{{$order->billed_amount ?? 0}}</span></li>
                                    <li> Discount({{$order->discount ?? 0}}%): <span class="fr">&#8377;{{$order->discount_amount ?? 0}}</span></li>
                                    <li> Taxes({{$order->tax ?? 0}}%): <span class="fr">&#8377;{{$order->tax ?? 0}}</span></li>
                                    <li class="total-c"> Total: <span class="fr">&#8377;{{$order->total ?? 0}}</span></li>
                                </ul>
                                <div style="text-align: right;">
                                    <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-md btn-primary" target="blank"><i class="align-middle" data-feather="printer"></i> Print</a>
                                    <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-md btn-success" target="blank"><i class="align-middle" data-feather="download"></i> Download</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

		        </div>
	        </div>
        </div>
    </div>
</section>
		<!-- /.content -->
@endsection