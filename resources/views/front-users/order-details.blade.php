@extends('front-users.layouts.app')

@section('title')
    Order Details
@endsection

@section('content')

    <style>
        .invoice-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .invoice-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .company-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        .student-name {
            font-size: 18px;
            font-weight: 600;
        }

        .student-info {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
        }

        .invoice-table th {
            background: #f3f4f6;
            font-size: 13px;
            text-transform: uppercase;
        }

        .total-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .total-table {
            width: 350px;
        }

        .total-table td {
            padding: 7px;
            font-size: 14px;
        }

        .total-table tr:last-child {
            font-weight: 700;
            font-size: 16px;
            background: #f3f4f6;
        }

        .invoice-actions {
            margin-top: 40px;
            text-align: center;
        }

        .invoice-actions .btn {
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>


    <section class="content">

        <div class="row">
            <div class="col-lg-12">

                <div class="invoice-card">

                    {{-- HEADER --}}

                    <div class="row invoice-header">

                        <div class="col-md-6">

                            <img src="{{asset('images/Neti-logo.svg#full')}}" style="height:45px;margin-bottom:10px">

                            <div class="company-title">
                                Adhyayanam Education
                            </div>

                            <div class="company-info">
                                Viaspir, Post Basahiya, Atrouliya<br>
                                Azamgarh, Uttar Pradesh, India - 223223<br>
                                Phone: +91-9120930909<br>
                                Email: adhyayaniasacademy@gmail.com
                            </div>

                        </div>


                        <div class="col-md-6 text-end">

                            <div class="student-name">
                                {{$order->student->name ?? ''}}
                            </div>

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

                                            <li style="margin:6px">
                                                {{ $paper->name }}
                                            </li>

                                        @endforeach
                                    @else
                                        {{ $order->package_name ?? '-' }}
                                    @endif

                                </td>

                                <td>{{$order->quantity ?? 0}}</td>

                                <td>₹{{$order->billed_amount ?? 0}}</td>

                            </tr>

                        </tbody>

                    </table>



                    {{-- TOTAL --}}

                    <div class="total-section">

                        <table class="table table-sm total-table">

                            <tr>
                                <td>Sub Total</td>
                                <td class="text-end">₹{{$order->billed_amount ?? 0}}</td>
                            </tr>

                            <tr>
                                <td>Discount ({{$order->discount ?? 0}}%)</td>
                                <td class="text-end">₹{{$order->discount_amount ?? 0}}</td>
                            </tr>

                            <tr>
                                <td>Taxes ({{$order->tax ?? 0}}%)</td>
                                <td class="text-end">₹{{$order->tax ?? 0}}</td>
                            </tr>

                            <tr>
                                <td>Total</td>
                                <td class="text-end">₹{{$order->total ?? 0}}</td>
                            </tr>

                        </table>

                    </div>



                    {{-- BUTTONS BOTTOM --}}

                    <div class="invoice-actions">

                        <a href="{{route('user.print-invoice', $order->id)}}" class="btn btn-primary" target="_blank">

                            <i data-feather="printer"></i> Print Invoice

                        </a>


                        <a href="{{route('user.generate-pdf', $order->id)}}" class="btn btn-success" target="_blank">

                            <i data-feather="download"></i> Download PDF

                        </a>

                    </div>


                </div>

            </div>
        </div>

    </section>

@endsection