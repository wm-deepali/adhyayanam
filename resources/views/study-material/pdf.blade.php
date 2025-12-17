<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Study Material PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .details {
            margin-top: 15px;
        }

        .row {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 160px;
            vertical-align: top;
        }

        .value {
            display: inline-block;
            width: calc(100% - 170px);
        }

        .section-title {
            margin-top: 25px;
            font-size: 15px;
            font-weight: bold;
            border-bottom: 1px solid #999;
            padding-bottom: 4px;
        }

        .content-box {
            margin-top: 8px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .section-box {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .section-box h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h2>Study Material Details</h2>
    </div>

    {{-- BASIC DETAILS --}}
    <div class="details">

        <div class="row">
            <span class="label">Commission:</span>
            <span class="value">{{ $material->commission->name ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span class="label">Category:</span>
            <span class="value">{{ $material->category->name ?? 'N/A' }}</span>
        </div>

        <div class="row">
            <span class="label">Sub Category:</span>
            <span class="value">{{ $material->subcategory->name ?? 'N/A' }}</span>
        </div>

        @if($material->subjects->count())
            <div class="row">
                <span class="label">Subject:</span>
                <span class="value">{{ $material->subjects->pluck('name')->implode(', ') }}</span>
            </div>
        @endif

        @if($material->chapters->count())
            <div class="row">
                <span class="label">Chapter:</span>
                <span class="value">{{ $material->chapters->pluck('name')->implode(', ') }}</span>
            </div>
        @endif

        @if($material->topics->count())
            <div class="row">
                <span class="label">Topic:</span>
                <span class="value">{{ $material->topics->pluck('name')->implode(', ') }}</span>
            </div>
        @endif

        <div class="row">
            <span class="label">Material Type:</span>
            <span class="value">
                {{ $material->based_on ?? ucwords(str_replace('_',' ',$material->material_type)) }}
            </span>
        </div>

        <div class="row">
            <span class="label">Language:</span>
            <span class="value">{{ ucfirst($material->language) }}</span>
        </div>

        <div class="row">
            <span class="label">Title:</span>
            <span class="value">{{ $material->title }}</span>
        </div>

        <div class="row">
            <span class="label">Short Description:</span>
            <span class="value">{{ $material->short_description }}</span>
        </div>

        <div class="row">
            <span class="label">Paid:</span>
            <span class="value">{{ $material->IsPaid ? 'Yes' : 'No' }}</span>
        </div>

        @if($material->IsPaid)
            <div class="row">
                <span class="label">MRP:</span>
                <span class="value">₹ {{ $material->mrp }}</span>
            </div>

            <div class="row">
                <span class="label">Discount:</span>
                <span class="value">{{ $material->discount }}%</span>
            </div>

            <div class="row">
                <span class="label">Offered Price:</span>
                <span class="value">₹ {{ $material->price }}</span>
            </div>
        @endif

        <div class="row">
            <span class="label">Status:</span>
            <span class="value">{{ $material->status }}</span>
        </div>

        <div class="row">
            <span class="label">PDF Downloadable:</span>
            <span class="value">{{ $material->is_pdf_downloadable ? 'Yes' : 'No' }}</span>
        </div>

        <div class="row">
            <span class="label">Created At:</span>
            <span class="value">{{ $material->created_at->format('d M, Y H:i A') }}</span>
        </div>
    </div>

    {{-- DETAIL CONTENT --}}
    <div class="section-title">Detail Content</div>
    <div class="content-box">
        {!! $material->detail_content !!}
    </div>

    {{-- SECTIONS --}}
    @if(!empty($material->sections) && count($material->sections))
        <div class="section-title">Sections</div>

        @foreach($material->sections as $index => $section)
            <div class="section-box">
                <h4>{{ $index + 1 }}. {{ $section->title }}</h4>
                {!! $section->description !!}
            </div>
        @endforeach
    @endif

</body>
</html>
