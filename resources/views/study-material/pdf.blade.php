<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Study Material PDF</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ url('android-chrome-512x512.png') }}">
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}">
    <link rel="manifest" href="{{ url('site.webmanifest') }}">

    <style>
        body {
            font-family: 'notodevanagari', sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #222;
        }

        /* ---- Top brand bar ---- */
        .brand-header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 2px solid #1e3a5f;
            margin-bottom: 10px;
        }

        .brand-header img {
            height: 55px;
            margin-bottom: 4px;
        }

        .brand-header .tagline {
            font-size: 11px;
            letter-spacing: 2px;
            color: #1e3a5f;
            font-weight: bold;
        }

        .ref-row {
            font-size: 10px;
            color: #555;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .ref-row .ref {
            float: left;
        }

        .ref-row .date {
            float: right;
        }

        .doc-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .doc-title-rule {
            border-bottom: 1px solid #ccc;
            margin-bottom: 14px;
        }

        /* ---- Details table ---- */
        table.details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.details-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }

        table.details-table tr:nth-child(even) {
            background-color: #f4f7fa;
        }

        table.details-table td.label {
            font-weight: bold;
            width: 150px;
            color: #1e3a5f;
        }

        /* ---- Section header bars ---- */
        .section-bar {
            background-color: #1e3a5f;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            padding: 6px 10px;
            margin-top: 18px;
            margin-bottom: 0;
        }

        .content-box {
            border: 1px solid #ddd;
            border-left: 4px solid #1e3a5f;
            background-color: #fafbfc;
            padding: 12px;
            margin-bottom: 10px;
        }

        .section-box {
            border: 1px solid #ddd;
            border-left: 4px solid #1e3a5f;
            background-color: #fafbfc;
            padding: 12px;
            margin-top: 10px;
        }

        .section-box h4 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #1e3a5f;
        }

        .section-box img {
            max-width: 200px;
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
            width: 300px;
            opacity: 0.08;
            transform: rotate(-30deg);
        }

        .watermark-text {
            font-size: 60px;
            color: rgba(0, 0, 0, 0.08);
            transform: rotate(-30deg);
            font-weight: bold;
        }

    </style>
</head>

<body>

     @if($logoBase64)
    <div class="watermark">
        <img src="{{ $logoBase64 }}" alt="Watermark Logo">
    </div>
@else
    <div class="watermark watermark-text">
        {{ config('app.name') }}
    </div>
@endif


    {{-- REF / DATE --}}
    <div class="ref-row">
        <span class="ref"><strong>Ref:</strong>
            {{ $material->based_on ?? ucwords(str_replace('_', ' ', $material->material_type)) }}</span>
        <span class="date"><strong>Date:</strong> {{ now()->format('d-M-Y') }}</span>
    </div>

    <div class="doc-title">Study Material Details</div>
    <div class="doc-title-rule"></div>

    {{-- DETAILS TABLE --}}
    <table class="details-table">
        <tr>
            <td class="label">Commission:</td>
            <td>{{ $material->commission->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Category:</td>
            <td>{{ $material->category->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Sub Category:</td>
            <td>{{ $material->subcategory->name ?? 'N/A' }}</td>
        </tr>
        @if($material->subjects->count())
            <tr>
                <td class="label">Subject:</td>
                <td>{{ $material->subjects->pluck('name')->implode(', ') }}</td>
            </tr>
        @endif
        @if($material->chapters->count())
            <tr>
                <td class="label">Chapter:</td>
                <td>{{ $material->chapters->pluck('name')->implode(', ') }}</td>
            </tr>
        @endif
        @if($material->topics->count())
            <tr>
                <td class="label">Topic:</td>
                <td>{{ $material->topics->pluck('name')->implode(', ') }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Material Type:</td>
            <td>{{ $material->based_on ?? ucwords(str_replace('_', ' ', $material->material_type)) }}</td>
        </tr>
        <tr>
            <td class="label">Language:</td>
            <td>{{ ucfirst($material->language) }}</td>
        </tr>
        <tr>
            <td class="label">Title:</td>
            <td>{{ $material->title }}</td>
        </tr>
        <tr>
            <td class="label" style="vertical-align:top;">Short Description:</td>
            <td>{{ $material->short_description }}</td>
        </tr>
        <tr>
            <td class="label">Paid:</td>
            <td>{{ $material->IsPaid ? 'Yes' : 'No' }}</td>
        </tr>
        @if($material->IsPaid)
            <tr>
                <td class="label">MRP:</td>
                <td>₹ {{ $material->mrp }}</td>
            </tr>
            <tr>
                <td class="label">Discount:</td>
                <td>{{ $material->discount }}%</td>
            </tr>
            <tr>
                <td class="label">Offered Price:</td>
                <td>₹ {{ $material->price }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Status:</td>
            <td>{{ $material->status }}</td>
        </tr>
        <tr>
            <td class="label">PDF Downloadable:</td>
            <td>{{ $material->is_pdf_downloadable ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <td class="label">Created At:</td>
            <td>{{ $material->created_at->format('d M, Y H:i A') }}</td>
        </tr>
    </table>

    {{-- DETAIL CONTENT --}}
    <div class="section-bar">DETAIL CONTENT</div>
    <div class="content-box">
        {!! $material->detail_content !!}
    </div>

    {{-- SECTIONS --}}
    @if(!empty($material->sections) && count($material->sections))
        <div class="section-bar">SECTIONS</div>

        @foreach($material->sections as $index => $section)
            <div class="section-box">
                <h4>{{ $index + 1 }}. {{ $section->title }}</h4>
                {!! $section->description !!}
            </div>
        @endforeach
    @endif

   
</body>

</html>