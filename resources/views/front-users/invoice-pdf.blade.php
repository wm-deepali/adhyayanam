<!DOCTYPE html>
<html>
<title>Order Invoice</title>

<head>
    <link rel="shortcut icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">
    <link rel="icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">

    <style>
        @page {
            size: A5;
            margin: 0px;
        }

        body {
            word-wrap: break-word;
            font-family: DejaVu Sans, 'sans-serif', 'Arial';
            font-size: 11px;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }

        .pdf-content {
            padding: 15px 20px 45px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 0.5pt solid #1a365d;
        }

        table td,
        table th {
            border: 0.5pt solid #cbd5e0;
            padding: 6px 8px;
            vertical-align: top;
        }

        table th {
            background-color: #f7fafc;
            color: #1a365d;
            font-weight: bold;
        }

        .style_hidden {
            border-style: hidden;
        }

        .fixed_table {
            table-layout: fixed;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .bg-sky {
            background-color: #E8F3FD;
        }

        #clockwise {
            rotate: 90;
        }

        #counterclockwise {
            rotate: -90;
        }

        .watermark {
            position: fixed;
            top: 35%;
            left: 0;
            right: 0;
            text-align: center;
            z-index: -1;
        }

        .watermark img {
            width: 250px;
            opacity: 0.05;
            transform: rotate(-30deg);
        }

        .watermark-text {
            font-size: 50px;
            color: rgba(0, 0, 0, 0.05);
            transform: rotate(-30deg);
            font-weight: bold;
        }

        .company-details {
            font-size: 10px;
            color: #4a5568;
            line-height: 1.4;
        }

        .company-name {
            font-weight: bold;
            font-size: 13px;
            color: #1a365d;
            margin: 4px 0;
        }

        /* ========================= */
        /* 🔹 Elegant Letterhead Styles */
        /* ========================= */
        .letterhead-wrapper {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .letterhead-band {
            height: 4px;
            background-color: #1a365d;
            margin-bottom: 2px;
            width: 100%;
        }

        .letterhead-accent-band {
            height: 1.5px;
            background-color: #d69e2e;
            margin-bottom: 8px;
            width: 100%;
        }

        .pdf-header {
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 2px double #1a365d;
            margin-left: 20px;
            margin-right: 20px;
        }

        .pdf-header img {
            height: 55px;
            max-height: 65px;
        }

        .site-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 20px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: 1px;
        }

        .header-tagline {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #718096;
            margin-top: 6px;
            font-weight: bold;
        }

        /* ========================= */
        /* 🔹 Elegant Footer Styles */
        /* ========================= */
        .pdf-footer {
            position: fixed;
            bottom: 10px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }

        .pdf-footer table.footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 0;
        }

        .pdf-footer table.footer-table td {
            border: none !important;
            padding: 0 !important;
            font-size: 8px !important;
            color: #718096 !important;
        }
    </style>
</head>

<body onload="window.print();"><!-- window.print() -->

    {{-- WATERMARK --}}
    @if($logoBase64)
    <div class="watermark">
        <img src="{{ $logoBase64 }}" alt="Watermark Logo">
    </div>
    @else
    <div class="watermark watermark-text">
        {{ config('app.name') }}
    </div>
    @endif

    <!-- ======================================= -->
    <!-- 🔹 LETTERHEAD TYPE HEADER (CENTERED LOGO) -->
    <!-- ======================================= -->
    <div class="letterhead-wrapper">
        <div class="letterhead-band"></div>
        <div class="letterhead-accent-band"></div>

        <div class="pdf-header">
            @if($logoBase64)
            <div style="margin-bottom: 6px;">
                <img src="{{ $logoBase64 }}">
            </div>
            @else
            <div class="site-name">{{ config('app.name') }}</div>
            @endif
            <div class="header-tagline">{{ strtoupper(config('app.name') ?? 'Adhyayanam') }} • ORDER INVOICE</div>
        </div>
    </div>

    <div class="pdf-content">
        <caption>
            <center>
                <span style="font-size: 16px;text-transform: uppercase;font-weight:bold;color:#1a365d;">
                    <i class="fa fa-globe"></i> Order Invoice
                </span>
            </center>
        </caption>

    <table autosize="1" style="overflow: wrap" id='mytable' align="center" width="100%" height='100%' cellpadding="0"
        cellspacing="0">


        <thead>

            <tr>
                <th colspan="16">
                    <table width="100%" height='100%' class="style_hidden fixed_table">
                        <tr>
                            <!-- First Half -->

                            <td colspan="8">
                                <div class="company-details">
                                    <div class="company-logo">
                                        @if($logoBase64)
                                        <img src="{{ $logoBase64 }}" style="height:60px;">
                                        @else
                                        <div style="font-size:22px;font-weight:bold;">
                                            {{ config('app.name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="company-name">Adhyayanam</div>
                                    <div class="company-address">Viaspir, Post Basahiya, Atrouliya, Azamgarh,Uttar
                                        Pradesh, India
                                        Pin Code - 223223 </div>
                                    <div class="company contact">
                                        Contact Number:+91-91209 30909<br>
                                        Email Id: adhyayaniasacademy@gmail.com<br>
                                    </div>
                                </div>
                            </td>

                            <!-- Second Half -->
                            <td colspan="8" rowspan="1">
                                <span>
                                    <table style="width: 100%;" class="style_hidden fixed_table">
                                        <tr>
                                            <td colspan="8">
                                                {{$order->student->name ?? ''}}
                                            </td>
                                        </tr>
                                        @if($order->student->full_address != '')
                                        <tr>
                                            <td colspan="8">
                                                {{$order->student->full_address ?? ''}}
                                            </td>
                                        </tr>

                                        @endif
                                        <tr>
                                            <td colspan="8">
                                                Phone :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->student->mobile ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Email :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->student->email ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Order Date & Time :
                                                <span style="font-size: 10px;">
                                                    <b>{{date('d-m-Y g:i A', strtotime($order->created_at))}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Order Id :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->order_code ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Order Type :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->order_type ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Payment Status :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->payment_status ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                Transaction Id :
                                                <span style="font-size: 10px;">
                                                    <b>{{$order->transaction_id ?? ''}}</b>
                                                </span>
                                            </td>
                                        </tr>








                                    </table>
                                </span>
                            </td>
                        </tr>







                    </table>
                </th>
            </tr>

            <tr>
                <td colspan="16">&nbsp; </td>
            </tr>
            <tr class="bg-sky"><!-- Colspan 10 -->
                <th colspan='2' class="text-center">Sr. No</th>
                <th colspan='4' class="text-center">Order Type</th>

                <th colspan='4' class="text-center">Detail</th>
                <th colspan='3' class="text-center">Quantity</th>
                <th colspan='3' class="text-center">Rates</th>

            </tr>
        </thead>



        <tbody>

            <tr>
                <td colspan='16'>
            <tr>
                <td colspan='2' class='text-center'>1</td>
                <td colspan='4' class='text-center'>{{$order->order_type}}</td>
                <td>

                    @if($course)
                    {{ $course->name ?? '-' }}

                    @elseif($studyMaterial)
                    {{ $studyMaterial->title ?? '-' }}


                    @elseif($testSeries)
                    {{ $testSeries->title ?? '-' }}

                    @elseif(isset($papers) && $papers->count())
                    @foreach($papers as $paper)

                    <li>
                        {{ $paper->name }}
                    </li>

                    @endforeach
                    @else
                    {{ $order->package_name ?? '-' }}
                    @endif

                </td>
                <td colspan='3' class='text-center'>{{$order->quantity ?? 0}}</td>
                <td colspan='3' class='text-center'>&#8377;{{$order->billed_amount ?? 0}}</td>
            </tr>

            </td>
            </tr>
            <tr>
                <td colspan="16">&nbsp; </td>
            </tr>
        </tbody>


        <tfoot>


            <tr class="bg-sky">
                <td colspan="12" class='text-right text-bold'>Sub Total: </td>
                <td colspan="4" class='text-right text-bold'>&#8377;{{$order->billed_amount ?? 0}}</td>
            </tr>
            <tr class="bg-sky">
                <td colspan="12" class='text-bold text-right'>Discount({{$order->discount ?? 0}}%): </td>
                <td colspan="4" class='text-bold text-right'>&#8377;{{$order->discount_amount ?? 0}}</td>
            </tr>
            <tr class="bg-sky">
                <td colspan="12" class='text-bold text-right'>Taxes({{$order->tax ?? 0}}%): </td>
                <td colspan="4" class='text-bold text-right'>&#8377;{{$order->tax ?? 0}}</td>
            </tr>
            <tr class="bg-sky">
                <td colspan="12" class='text-bold text-right'>Total: </td>
                <td colspan="4" class='text-bold text-right'>&#8377;{{$order->total ?? 0}}</td>
            </tr>









    </table>
    </td>
    </tr>
    <!-- T&C & Bank Details & signatories End -->


    </tfoot>

    </table>

    </div>

    <!-- ========================= -->
    <!-- 🔹 ELEGANT FOOTER DESIGN -->
    <!-- ========================= -->
    <div class="pdf-footer">
        <table class="footer-table">
            <tr>
                <td style="text-align: left;">
                    © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
                </td>
                <td style="text-align: right;">
                    Confidential Invoice Document
                </td>
            </tr>
        </table>
    </div>

</body>

</html>