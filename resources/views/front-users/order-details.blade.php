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

        .payment-status-note {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #9a3412;
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

    @php
        // payment_status stores: PAID | FAILED | CANCELLED | PENDING
        $badgeClass = match ($order->payment_status) {
            'PAID' => 'bg-success',
            'CANCELLED' => 'bg-secondary',
            'PENDING' => 'bg-warning text-dark',
            default => 'bg-danger', // Failed
        };

        $isPaid = $order->payment_status == 'PAID';
        $isPending = $order->payment_status == 'PENDING';

        // ✅ FIX: PENDING no longer talks about "refund" — nothing has failed yet,
        // the payment is still awaiting bank confirmation. Refund language is
        // reserved for FAILED / CANCELLED where money may actually have moved
        // and come back.
        $statusNote = match ($order->payment_status) {
            'CANCELLED' => 'This payment was cancelled before completion. No amount was deducted.',
            'PENDING' => 'This payment is still awaiting confirmation from your bank. This can take a few minutes — please do not make a second payment for this order. This page will reflect the final status automatically once confirmed.',
            'FAILED' => 'This payment could not be completed. If any amount was deducted, it will be refunded automatically within 5-7 business days.',
            default => null,
        };
    @endphp

    <section class="content py-3">
        <div class="container p-0">

            <!-- ==================== DESKTOP VIEW ==================== -->
            <div class="d-none d-lg-block">
                <div class="invoice-card">

                    @if($statusNote)
                        <div class="payment-status-note">
                            <strong>{{ $order->payment_status }}:</strong> {{ $statusNote }}
                        </div>
                    @endif

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
                                <span class="badge {{ $badgeClass }}">{{$order->payment_status}}</span><br>
                                <strong>Payment Mode :</strong> {{$order->payment_mode ?? '-'}} <br>
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
                            <tr>
                                <td>Sub Total</td>
                                <td class="text-end">₹{{ number_format($order->billed_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Discount ({{$order->discount ?? 0}}%)</td>
                                <td class="text-end">- ₹{{ number_format($order->discount_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Taxes</td>
                                <td class="text-end">₹{{ number_format($order->tax ?? 0, 2) }}</td>
                            </tr>
                            @if(($order->wallet_used ?? 0) > 0)
                                <tr>
                                    <td>
                                        Wallet Amount Used
                                        @if(!$isPaid && !$isPending && ($order->wallet_refunded ?? false))
                                            <span class="text-muted small">(refunded)</span>
                                        @endif
                                    </td>
                                    <td class="text-end">- ₹{{ number_format($order->wallet_used, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>{{ $isPaid ? 'Paid via Gateway' : 'Total' }}</strong></td>
                                <td class="text-end"><strong>₹{{ number_format($order->total - ($order->wallet_used ?? 0), 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>

                    {{-- ACTIONS --}}
                    @if($isPaid)
                        <div class="invoice-actions">
                            <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-primary me-3" target="_blank">
                                <i data-feather="printer"></i> Print Invoice
                            </a>
                            <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-success" target="_blank">
                                <i data-feather="download"></i> Download PDF
                            </a>
                        </div>
                    @elseif($isPending)
                        {{-- ✅ FIX: no "Back to Orders" implying it's over — just let
                        them refresh, since resolveAndSaveOrder() will update this
                        order automatically once the webhook/return_url fires. --}}
                        <div class="invoice-actions">
                            <a href="{{ url()->current() }}" class="btn btn-outline-warning">
                                <i data-feather="refresh-cw"></i> Refresh Status
                            </a>
                        </div>
                    @else
                        <div class="invoice-actions">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i data-feather="arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    @endif
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

                    @if($statusNote)
                        <div class="payment-status-note">
                            <strong>{{ $order->payment_status }}:</strong> {{ $statusNote }}
                        </div>
                    @endif

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
                            <span class="badge {{ $badgeClass }}">{{$order->payment_status}}</span>
                        </div>
                        <div class="mobile-detail-row">
                            <span><strong>Payment Mode</strong></span>
                            <span>{{$order->payment_mode ?? '-'}}</span>
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
                            <span>₹{{ number_format($order->billed_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="mobile-total-row">
                            <span>Discount ({{$order->discount ?? 0}}%)</span>
                            <span>- ₹{{ number_format($order->discount_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="mobile-total-row">
                            <span>Taxes</span>
                            <span>₹{{ number_format($order->tax ?? 0, 2) }}</span>
                        </div>
                        @if(($order->wallet_used ?? 0) > 0)
                            <div class="mobile-total-row">
                                <span>
                                    Wallet Amount Used
                                    @if(!$isPaid && !$isPending && ($order->wallet_refunded ?? false))
                                        <span class="text-muted small">(refunded)</span>
                                    @endif
                                </span>
                                <span>- ₹{{ number_format($order->wallet_used, 2) }}</span>
                            </div>
                        @endif
                        <div class="mobile-total-row final">
                            <span>{{ $isPaid ? 'Paid via Gateway' : 'Total Amount' }}</span>
                            <span>₹{{ number_format($order->total - ($order->wallet_used ?? 0), 2) }}</span>
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
                    @if($isPaid)
                        <div class="mt-5 d-grid gap-3">
                            <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-primary btn-lg"
                                target="_blank">
                                <i data-feather="printer"></i> Print Invoice
                            </a>
                            <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-success btn-lg" target="_blank">
                                <i data-feather="download"></i> Download PDF
                            </a>
                        </div>
                    @elseif($isPending)
                        <div class="mt-5 d-grid gap-3">
                            <a href="{{ url()->current() }}" class="btn btn-outline-warning btn-lg">
                                <i data-feather="refresh-cw"></i> Refresh Status
                            </a>
                        </div>
                    @else
                        <div class="mt-5 d-grid gap-3">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
                                <i data-feather="arrow-left"></i> Back to Orders
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection