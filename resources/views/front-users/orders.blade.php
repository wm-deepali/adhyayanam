@extends('front-users.layouts.app')

@section('title')
Orders
@endsection

@section('content')
<section class="content">
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Order History</h5>
							<p class="mb-0 card-subtitle text-muted"></p>
						</div>
						<div class="card-body">
							<table class="table">
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
                                            <a href="{{route('user.order-details',$res->id)}}"><i class="align-middle" data-feather="eye"></i></a>
                                            <a href="#" class="text-fade hover-primary"><i class="align-middle" data-feather="trash"></i></a>
                                           
                                        </td>
                                    </tr>
                                    @endforeach
								
								</tbody>
							</table>
						</div>
					</div>
				</div>

			

				
			</div>
		</section>
		<!-- /.content -->
@endsection