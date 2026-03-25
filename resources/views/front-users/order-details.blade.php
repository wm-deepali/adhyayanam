@extends('front-users.layouts.app')

@section('title')
    Order Details
@endsection

@section('content')

    <style>
        /* ====================== DESKTOP INVOICE ====================== */
        .invoice-card {
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .invoice-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 25px;
            margin-bottom: 25px;
        }

        .company-title {
            font-size: 22px;
            font-weight: 700;
        }

        .invoice-table th {
            background: #f8fafc;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .total-table tr:last-child {
            font-weight: 700;
            font-size: 17px;
            background: #f8fafc;
        }

        /* ====================== MOBILE PREMIUM INVOICE ====================== */
        .mobile-invoice {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin: 15px 10px;
        }

        .mobile-invoice-header {
            background: #f9f9f9;
            color: #000000;
            padding: 25px 20px;
            text-align: center;
        }

        .mobile-invoice-header .logo {
            height: 50px;
            margin-bottom: 12px;
        }

        .mobile-invoice-body {
            padding: 20px 15px;
        }

        .mobile-order-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .mobile-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .mobile-detail-row:last-child {
            border-bottom: none;
        }

        .mobile-total {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 18px;
            margin: 25px 0;
        }

        .mobile-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .mobile-total-row.final {
            font-size: 18px;
            font-weight: 700;
            color: #1e2937;
            border-top: 2px solid #cbd5e1;
            padding-top: 12px;
            margin-top: 12px;
        }
        @media (max-width: 740px) {
    
    .content {
    min-height: 250px;
    padding: 0 !important;
    margin-right: auto;
    margin-left: auto;
}

}
    </style>

    <section class="content py-3">
        <div class="container p-0">

            <!-- ==================== DESKTOP VIEW ==================== -->
            <div class="d-none d-lg-block">
                <div class="invoice-card">
                    {{-- HEADER --}}
                    <div class="row invoice-header">
                        <div class="col-md-6">
                            <img src="{{ url('images/Neti-logo.png')}}" style="height:45px;margin-bottom:10px" alt="Logo">
                            <div class="company-title">Adhyayanam Education</div>
                            <div class="company-info">
                                Viaspir, Post Basahiya, Atrouliya<br>
                                Azamgarh, Uttar Pradesh, India - 223223<br>
                                Phone: +91-9120930909<br>
                                Email: adhyayaniasacademy@gmail.com
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="student-name">{{$order->student->name ?? ''}}</div>
                            <div class="student-info">
                                {{$order->student->full_address ?? ''}}<br>
                                Phone: {{$order->student->mobile ?? ''}}<br>
                                Email: {{$order->student->email ?? ''}}<br><br>
                                <strong>Order ID :</strong> {{$order->order_code}} <br>
                                <strong>Order Type :</strong> {{$order->order_type}} <br>
                                <strong>Payment Status :</strong> 
                                <span class="badge bg-success">{{$order->payment_status}}</span><br>
                                <strong>Transaction ID :</strong> {{$order->transaction_id ?? ''}} <br>
                                <strong>Date :</strong> {{date('d M Y, h:i A', strtotime($order->created_at))}}
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <table class="table table-bordered invoice-table">
                        <thead>
                            <tr>
                                <th width="60">SR</th>
                                <th>ORDER TYPE</th>
                                <th>DETAILS</th>
                                <th width="100">QTY</th>
                                <th width="120">RATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{$order->order_type}}</td>
                                <td>
                                    @if($course)
                                        {{ $course->name ?? '-' }}
                                    @elseif($studyMaterial)
                                        {{ $studyMaterial->title ?? '-' }}
                                    @elseif($testSeries)
                                        {{ $testSeries->title ?? '-' }}
                                    @elseif(isset($papers) && $papers->count())
                                        @foreach($papers as $paper)
                                            {{ $paper->name }}<br>
                                        @endforeach
                                    @else
                                        {{ $order->package_name ?? '-' }}
                                    @endif
                                </td>
                                <td>{{$order->quantity ?? 1}}</td>
                                <td>₹{{$order->billed_amount ?? 0}}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- TOTAL --}}
                    <div class="total-section">
                        <table class="table table-sm total-table">
                            <tr><td>Sub Total</td><td class="text-end">₹{{$order->billed_amount ?? 0}}</td></tr>
                            <tr><td>Discount ({{$order->discount ?? 0}}%)</td><td class="text-end">- ₹{{$order->discount_amount ?? 0}}</td></tr>
                            <tr><td>Taxes</td><td class="text-end">₹{{$order->tax ?? 0}}</td></tr>
                            <tr><td><strong>Total</strong></td><td class="text-end"><strong>₹{{$order->total ?? 0}}</strong></td></tr>
                        </table>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="invoice-actions">
                        <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-primary me-3" target="_blank">
                            <i data-feather="printer"></i> Print Invoice
                        </a>
                        <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-success" target="_blank">
                            <i data-feather="download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- ==================== MOBILE PREMIUM VIEW ==================== -->
            <div class="d-lg-none mobile-invoice">
                <div class="mobile-invoice-header">
                    <img src="{{ url('images/Neti-logo.png')}}" class="logo" alt="Logo">
                    <h4 class="mb-1 mt-3">Adhyayanam Education</h4>
                    <p class="mb-0 opacity-75 small">Order Receipt</p>
                </div>

                <div class="mobile-invoice-body">
                    <div class="mobile-order-info">
                        <div class="mobile-detail-row">
                            <span><strong>Order ID</strong></span>
                            <span>{{$order->order_code}}</span>
                        </div>
                        <div class="mobile-detail-row">
                            <span><strong>Date</strong></span>
                            <span>{{date('d M Y, h:i A', strtotime($order->created_at))}}</span>
                        </div>
                        <div class="mobile-detail-row">
                            <span><strong>Payment Status</strong></span>
                            <span class="badge bg-success">{{$order->payment_status}}</span>
                        </div>
                        <div class="mobile-detail-row">
                            <span><strong>Transaction ID</strong></span>
                            <span>{{$order->transaction_id ?? 'N/A'}}</span>
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary">Order Details</h5>
                    <div class="mobile-detail-row">
                        <span><strong>Item</strong></span>
                        <span class="text-end">
                            @if($course) {{ $course->name }}
                            @elseif($studyMaterial) {{ $studyMaterial->title }}
                            @elseif($testSeries) {{ $testSeries->title }}
                            @else {{ $order->package_name ?? '-' }}
                            @endif
                        </span>
                    </div>
                    <div class="mobile-detail-row">
                        <span><strong>Order Type</strong></span>
                        <span>{{$order->order_type}}</span>
                    </div>
                    <div class="mobile-detail-row">
                        <span><strong>Quantity</strong></span>
                        <span>{{$order->quantity ?? 1}}</span>
                    </div>

                    <!-- Total Section -->
                    <div class="mobile-total">
                        <div class="mobile-total-row">
                            <span>Sub Total</span>
                            <span>₹{{$order->billed_amount ?? 0}}</span>
                        </div>
                        <div class="mobile-total-row">
                            <span>Discount ({{$order->discount ?? 0}}%)</span>
                            <span>- ₹{{$order->discount_amount ?? 0}}</span>
                        </div>
                        <div class="mobile-total-row">
                            <span>Taxes</span>
                            <span>₹{{$order->tax ?? 0}}</span>
                        </div>
                        <div class="mobile-total-row final">
                            <span>Total Amount</span>
                            <span>₹{{$order->total ?? 0}}</span>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="mt-4 pt-3 border-top">
                        <strong>Billed To:</strong><br>
                        <strong>{{$order->student->name ?? ''}}</strong><br>
                        {{$order->student->full_address ?? ''}}<br>
                        {{$order->student->mobile ?? ''}} | {{$order->student->email ?? ''}}
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-5 d-grid gap-3">
                        <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-primary btn-lg" target="_blank">
                            <i data-feather="printer"></i> Print Invoice
                        </a>
                        <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-success btn-lg" target="_blank">
                            <i data-feather="download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection