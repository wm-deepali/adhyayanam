@extends('front-users.layouts.app')

@section('title')
Orders
@endsection

<style>
    .order-card .card {
   border-radius: 5px;
    padding: 10px;
    background: #f6fff0;
    transition: transform 0.2s;
}

.order-card .card:hover {
    transform: translateY(-3px);
}

@media (max-width: 991.98px) {
    .table-responsive {
        overflow-x: auto;
    }
   
}
@media (max-width: 740px) {
    
    .content {
    min-height: 250px;
    padding: 0 !important;
    margin-right: auto;
    margin-left: auto;
}
.order-cards{
    padding:10px;
}
}
</style>

@section('content')
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Order History</h5>
                </div>
                <div class="card-body p-0 p-md-3">

                    <!-- Desktop Table (lg and above) -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Order Id</th>
                                    <th>Order Type</th>
                                    <th>Paid Amount</th>
                                    <th>Payment Status</th>
                                    <th>Transaction ID</th>
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $res)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($res->created_at)->format('d M Y, h:i A') }}</td>
                                        <td><strong>{{ $res->order_code ?? '-' }}</strong></td>
                                        <td>{{ $res->order_type ?? '-' }}</td>
                                        <td><strong>₹{{ number_format($res->total ?? 0) }}</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $res->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($res->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $res->transaction_id ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $res->order_status == 'completed' ? 'success' : 'info' }}">
                                                {{ ucfirst($res->order_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{route('user.order-details',$res->id)}}" class="btn btn-sm btn-primary me-1">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger">
                                                <i data-feather="trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile + Tablet Card View -->
                    

                </div>
                <div class="order-cards d-lg-none">
                        @foreach($orders as $res)
                            <div class="order-card mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <strong class="fs-5">{{ $res->order_code ?? '-' }}</strong>
                                                <p class="text-muted mb-0 small">
                                                    {{ \Carbon\Carbon::parse($res->created_at)->format('d M Y, h:i A') }}
                                                </p>
                                            </div>
                                            <span class="badge bg-{{ $res->payment_status == 'paid' ? 'success' : 'warning' }} fs-6">
                                                ₹{{ number_format($res->total ?? 0) }}
                                            </span>
                                        </div>

                                        <div class="row g-2 text-muted small">
                                            <div class="col-6">
                                                <strong>Order Type:</strong><br>
                                                {{ $res->order_type ?? '-' }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Transaction ID:</strong><br>
                                                {{ $res->transaction_id ?? '-' }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Payment:</strong><br>
                                                <span class="badge bg-{{ $res->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($res->payment_status) }}
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Status:</strong><br>
                                                <span class="badge bg-{{ $res->order_status == 'completed' ? 'success' : 'info' }}">
                                                    {{ ucfirst($res->order_status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-3 border-top d-flex gap-2">
                                            <a href="{{route('user.order-details',$res->id)}}" 
                                               class="btn btn-primary flex-fill">
                                                <i data-feather="eye" class="me-2"></i> View Details
                                            </a>
                                            <a href="#" class="btn btn-outline-danger flex-fill">
                                                <i data-feather="trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</section>
		<!-- /.content -->
@endsection